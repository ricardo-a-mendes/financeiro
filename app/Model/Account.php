<?php

namespace App\Model;

use App\FinancialModel;

class Account extends FinancialModel
{
   public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }
}
