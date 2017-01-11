<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public $timestamps = false;

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getCombo()
    {
        return $this->pluck('name', 'id')->all();
    }
}
