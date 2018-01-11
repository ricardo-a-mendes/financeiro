<?php

namespace App\Model;

use App\FinancialModel;

class TransactionType extends FinancialModel
{
    const TRANSACTION_TYPE_CREDIT = 'credit';
    const TRANSACTION_TYPE_DEBIT = 'debit';
    const TRANSACTION_TYPE_POST = 'pos';

    public function getNameAttribute()
    {
        return trans('transaction.'.$this->unique_name);
    }
}
