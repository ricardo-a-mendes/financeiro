<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{

    const STATEMENT_CREDIT = 1;
    const STATEMENT_DEBIT = 2;
    const TOTAL_TYPE_VALUE = 'value';
    const TOTAL_TYPE_POSTED = 'posted_value';
    const TOTAL_TYPE_PROVISION = 'provision_value';

    public $provision;
    public $transaction;

    public function __construct()
    {
        $this->provision = new Provision();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function getTransactionDateBRAttribute()
    {
        return date('d/m/Y', strtotime($this->transaction_date));
    }

    public function getStatement($userID, $type, \DateTime $date = null)
    {
        if (!in_array($type, [self::STATEMENT_CREDIT, self::STATEMENT_DEBIT]))
            throw new \InvalidArgumentException('Invalid Type');


        if (is_null($date))
            $date = new \DateTime();

        $startDate = $date->format('Y-m-01 00:00:00');
        $endDate = $date->format('Y-m-t 23:59:59');

        $fields = DB::raw('
            categories.id,
            categories.name as category,
            (select 
                sum(provisions.value)
            from 
                provisions
            left join provision_dates on provision_dates.provision_id = provisions.id and provision_dates.user_id = '.$userID.'
                
            where 
            	provisions.user_id = '.$userID.'
                and provisions.category_id = categories.id
                and (
                    provision_dates.target_date between \''.$startDate.'\' and \''.$endDate.'\' 
                    or 
                    provision_dates.id is null
                )
            ) as provision_value,
            sum(transactions.value) as posted_value'
        );

        $provisionsWithoutTransaction = $this->provision->getWithoutTransaction($userID, $type, $date);

        $statements = $this->select($fields)
            ->join('transaction_types', 'transaction_types.id', '=', 'transactions.transaction_type_id')
            ->join('categories', function ($join) use ($userID){
				$join->where('categories.user_id', $userID);
				$join->on('categories.id', 'transactions.category_id');
			})
            ->where('transactions.user_id', $userID)
            ->where('transaction_type_id', $type)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->groupBy('categories.id')
            ->groupBy('categories.name')
            ->union($provisionsWithoutTransaction);

        return $statements->get();
    }

    public function getTotal($statement, $type = self::TOTAL_TYPE_POSTED)
    {
        if (!in_array($type, [self::TOTAL_TYPE_VALUE, self::TOTAL_TYPE_PROVISION, self::TOTAL_TYPE_POSTED]))
            throw new \InvalidArgumentException('Invalid Type');

        $total = 0;
        foreach ($statement as $item)
           $total += $item->$type;

        return $total;
    }
}
