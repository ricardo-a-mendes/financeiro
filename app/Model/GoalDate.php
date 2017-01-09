<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoalDate extends Model
{
    public $timestamps = false;

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
