<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoalDate extends Model
{
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
