<?php

namespace App\Model;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{

    const STATEMENT_CREDIT = 1;
    const STATEMENT_DEBIT = 2;
    const TOTAL_TYPE_VALUE = 'value';
    const TOTAL_TYPE_POSTED = 'posted_value';
    const TOTAL_TYPE_PROVISION = 'provisioned_value';
    const STATEMENT_DB_DATE_FORMAT = 'Y-m-d';

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function getTransactionDateBRAttribute()
    {
        return date('d/m/Y', strtotime($this->transaction_date));
    }

    public function getDebitTransactions(Carbon $startsAt, Carbon $endsAt, int $accountId)
    {
        return $this->getTransactions($startsAt, $endsAt, $accountId, self::STATEMENT_DEBIT);
    }

    public function getCreditTransactions(Carbon $startsAt, Carbon $endsAt, int $accountId)
    {
        return $this->getTransactions($startsAt, $endsAt, $accountId, self::STATEMENT_CREDIT);
    }

    private function getTransactions(Carbon $startsAt, Carbon $endsAt, int $accountId, int $transactionType)
    {
        return DB::select("CALL sp_statement(?, ?, ?, ?)", [
                $startsAt->format(self::STATEMENT_DB_DATE_FORMAT),
                $endsAt->format(self::STATEMENT_DB_DATE_FORMAT),
                $accountId,
                $transactionType
            ]);
    }

    /**
     * @param int $accountID
     * @param int $type
     * @param Carbon|null $date
     * @return mixed
     */
    public function getStatement(int $accountID, int $type, Carbon $date = null)
    {
        if (!in_array($type, [self::STATEMENT_CREDIT, self::STATEMENT_DEBIT]))
            throw new \InvalidArgumentException('Invalid Type');


        if (is_null($date))
            $date = new Carbon();

        $startDate = Carbon::createFromFormat('Y-m-d', $date->format('Y-m-01'));
        $endDate = Carbon::createFromFormat('Y-m-d', $date->format('Y-m-t'));

        return $this->getTransactions($startDate, $endDate, $accountID, $type);
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
