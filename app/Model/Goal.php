<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Goal extends Model
{
    public function getGoalsWithoutTransaction($type)
    {
        $fields = DB::raw('
            categories.id,
            categories.description as category,
            sum(goals.value) as goal_value,
            0 as effected_value'
        );

        return $this->select($fields)
            ->leftJoin('goal_dates', 'goal_dates.goal_id', '=', 'goals.id')
            ->leftJoin('categories', 'categories.id', '=', 'goals.category_id')
            ->leftJoin('transactions', 'transactions.category_id', '=', 'categories.id')
            ->where('goals.transaction_type_id', $type)
            ->whereNull('transactions.id')
            ->whereRaw('(
                goal_dates.target_date between \'2016-12-01 00:00:00\' and \'2016-12-31 23:59:59\' 
                or 
                goal_dates.id is null
            )')
            ->groupBy('categories.id')
            ->groupBy('categories.description');
    }
}
