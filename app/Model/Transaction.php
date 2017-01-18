<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{

    const STATEMENT_CREDIT = 1;
    const STATEMENT_DEBIT = 2;
    const TOTAL_TYPE_VALUE = 'value';
    const TOTAL_TYPE_EFFECTED = 'effected_value';
    const TOTAL_TYPE_GOAL = 'goal_value';

    public $goal;
    public $transaction;

    public function __construct()
    {
        $this->goal = new Goal();
        //$this->transaction = new Transaction();
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
                sum(goals.value)
            from 
                goals
            left join goal_dates on goal_dates.goal_id = goals.id and goal_dates.user_id = '.$userID.'
                
            where 
            	goals.user_id = '.$userID.'
                and goals.category_id = categories.id
                and (
                    goal_dates.target_date between \''.$startDate.'\' and \''.$endDate.'\' 
                    or 
                    goal_dates.id is null
                )
            ) as goal_value,
            sum(transactions.value) as effected_value'
        );

        $goalsWithoutTransaction = $this->goal->getGoalsWithoutTransaction($userID, $type, $date);

        return $this->select($fields)
            ->join('transaction_types', 'transaction_types.id', '=', 'transactions.transaction_type_id')
            ->join('categories', function ($join) use ($userID){
				$join->where('categories.user_id', $userID);
				$join->on('categories.id', 'transactions.category_id');
			})
            ->where('transactions.user_id', $userID)
            ->where('transaction_type_id', $type)
            ->whereBetween('transaction_date', ["'".$startDate."'", "'".$endDate."'"])
            ->groupBy('categories.id')
            ->groupBy('categories.name')
            ->union($goalsWithoutTransaction)
            ->get();
    }

    public function getTotal($statement, $type = 'effected_value')
    {
        if (!in_array($type, [self::TOTAL_TYPE_VALUE, self::TOTAL_TYPE_GOAL, self::TOTAL_TYPE_EFFECTED]))
            throw new \InvalidArgumentException('Invalid Type');

        $total = 0;
        foreach ($statement as $item)
           $total += $item->$type;

        return $total;
    }
}
