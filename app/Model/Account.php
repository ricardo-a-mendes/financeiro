<?php

namespace App\Model;

use App\FinancialModel;

class Account extends FinancialModel
{
    protected $fillable = [
        'account_type_id', 'status',
    ];

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }
}
