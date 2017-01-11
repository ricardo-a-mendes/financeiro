<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = false;

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function getCombo()
    {
        return $this->pluck('name', 'id')->all();
    }
}
