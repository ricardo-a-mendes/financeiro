<?php

namespace App\Model;

use App\FinancialModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function provisionDate()
    {
        return $this->hasMany(ProvisionDate::class);
    }

    public function getSpecificDateAttribute()
    {
        if ($this->provisionDate->count() > 0) {
            $specificDate = new Carbon($this->provisionDate->first()->target_date);
            return $specificDate->format('Y-m-d');
        }
        return null;
    }

    public function getWithoutTransaction($userID, $type, \DateTime $date = null)
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
            ->leftJoin('provision_dates', function ($join) use ($userID){
				$join->where('provision_dates.user_id', $userID);
				$join->on('provision_dates.provision_id', 'provisions.id');
			})
            ->leftJoin('categories', function ($join) use ($userID){
				$join->where('categories.user_id', $userID);
				$join->on('categories.id', 'provisions.category_id');
			})
            ->leftJoin('transactions', function($join) use ($userID, $startDate, $endDate){
                $join->where('transactions.user_id', $userID);
                $join->on('transactions.category_id', 'categories.id');
                $join->on('transactions.transaction_date', 'between', DB::raw("'{$startDate}' and '{$endDate}'"));
            })
            ->where('provisions.user_id', $userID)
            ->where('provisions.transaction_type_id', $type)
            ->whereNull('transactions.id')
            ->whereRaw('(
                provision_dates.target_date between \''.$startDate.'\' and \''.$endDate.'\'
                or 
                provision_dates.id is null
            )')
            ->groupBy('categories.id')
            ->groupBy('categories.name');
    }
}
