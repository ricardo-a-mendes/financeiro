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

    private $goal;

    public function __construct()
    {
        $this->goal = new Goal();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getStatement($type)
    {
        if (!in_array($type, [self::STATEMENT_CREDIT, self::STATEMENT_DEBIT]))
            throw new \InvalidArgumentException('Invalid Type');

        $fields = DB::raw('
            categories.id,
            categories.name as category,
            (select 
                sum(goals.value)
            from 
                goals
            left join goal_dates on goal_dates.goal_id = goals.id 
                
            where 
                goals.category_id = categories.id
                and (
                    goal_dates.target_date between \'2016-12-01 00:00:00\' and \'2016-12-31 23:59:59\' 
                    or 
                    goal_dates.id is null
                )
            ) as goal_value,
            sum(transactions.value) as effected_value'
        );

        $goalsWithoutTransaction = $this->goal->getGoalsWithoutTransaction($type);

        return $this->select($fields)
            ->join('transaction_types', 'transaction_types.id', '=', 'transactions.transaction_type_id')
            ->join('categories', 'categories.id', '=', 'transactions.category_id')
            ->where('transaction_type_id', '=', $type)
            ->whereBetween('transaction_date', ['2016-12-01 00:00:00', '2016-12-31 23:59:59'])
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
