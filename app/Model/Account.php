<?php

namespace App\Model;

use App\FinancialModel;
use App\User;

class Account extends FinancialModel
{
    protected $fillable = [
        'account_type_id', 'status',
    ];

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
