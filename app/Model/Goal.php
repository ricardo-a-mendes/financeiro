<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Goal extends Model
{
    public $timestamps = false;

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function goalDate()
    {
        return $this->hasMany(GoalDate::class);
    }

    public function getSpecificDateAttribute()
    {
        if ($this->goalDate->count() > 0) {
            $specificDate = new Carbon($this->goalDate->first()->target_date);
            return $specificDate->format('Y-m-d');
        }
        return null;
    }

    public function getGoalsWithoutTransaction($userID, $type, \DateTime $date = null)
    {
        if (is_null($date))
            $date = new \DateTime();

        $startDate = $date->format('Y-m-01 00:00:00');
        $endDate = $date->format('Y-m-t 23:59:59');

        $fields = DB::raw('
            categories.id,
            categories.name as category,
            sum(goals.value) as goal_value,
            0 as effected_value'
        );

        return $this->select($fields)
            ->leftJoin('goal_dates', function ($join) use ($userID){
				$join->where('goal_dates.user_id', $userID);
				$join->on('goal_dates.goal_id', 'goals.id');
			})
            ->leftJoin('categories', function ($join) use ($userID){
				$join->where('categories.user_id', $userID);
				$join->on('categories.id', 'goals.category_id');
			})
            ->leftJoin('transactions', function($join) use ($userID, $startDate, $endDate){
                $join->where('transactions.user_id', $userID);
                $join->on('transactions.category_id', 'categories.id');
                $join->on('transactions.transaction_date', 'between', DB::raw("'{$startDate}' and '{$endDate}'"));
            })
            ->where('goals.user_id', $userID)
            ->where('goals.transaction_type_id', $type)
            ->whereNull('transactions.id')
            ->whereRaw('(
                goal_dates.target_date between \''.$startDate.'\' and \''.$endDate.'\'
                or 
                goal_dates.id is null
            )')
            ->groupBy('categories.id')
            ->groupBy('categories.name');
    }
}
