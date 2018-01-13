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

    public function getByUniqueName(string $uniqueName)
    {
        return $this->where('unique_name', $uniqueName)->first();
    }
}
