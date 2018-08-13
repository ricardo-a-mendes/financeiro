<?php

namespace App\Model;

use App\FinancialModel;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

/**
 * Class Provision
 * @package App\Model
 *
 * @method Provision find($id)
 *
 */
class Provision extends FinancialModel
{
    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function provisionDates()
    {
        return $this->hasMany(ProvisionDate::class);
    }

    public function getSpecificDateAttribute()
    {
        if (isset($this->provisionDate) && $this->provisionDate->count() > 0) {
            $specificDate = new Carbon($this->provisionDate->first()->target_date);
            return $specificDate->format('Y-m-d');
        }
        return null;
    }

    public function getWithoutTransaction($accountID, $type, \DateTime $date = null)
    {
        if (is_null($date))
            $date = new \DateTime();

        $startDate = $date->format('Y-m-01 00:00:00');
        $endDate = $date->format('Y-m-t 23:59:59');

        $fields = DB::raw('
            categories.id,
            categories.name as category,
            sum(provisions.value) as provision_value,
            0 as effected_value'
        );

        return $this->select($fields)
//            ->leftJoin('provision_dates', function ($join) use ($accountID){
//				$join->where('provision_dates.account_id', $accountID);
//				$join->on('provision_dates.provision_id', 'provisions.id');
//			})
            ->leftJoin('categories', function ($join) use ($accountID){
				$join->where('categories.account_id', $accountID);
				$join->on('categories.id', 'provisions.category_id');
			})
            ->leftJoin('transactions', function(JoinClause $join) use ($accountID, $startDate, $endDate){
                $join->where('transactions.account_id', $accountID);
                $join->on('transactions.category_id', 'categories.id');
                $join->whereBetween('transactions.transaction_date', ["'".$startDate."'","'".$endDate."'"]);
            })
            ->where('provisions.status', 1)
            ->where('provisions.account_id', $accountID)
            ->where('provisions.transaction_type_id', $type)
            ->whereNull('transactions.id')
//            ->whereRaw('(
//                provision_dates.target_date between \''.$startDate.'\' and \''.$endDate.'\'
//                or
//                provision_dates.id is null
//            )')
            ->groupBy('categories.id')
            ->groupBy('categories.name');
    }
}
