<?php

namespace App\Model;

use App\FinancialModel;

class AccountType extends FinancialModel
{
    protected $fillable = ['unique_name'];

    public function getNameAttribute()
    {
        return trans('account.'.$this->unique_name);
    }
}
