<?php

namespace App\Model;

use App\FinancialModel;

const TRANSACTION_CREDIT = 'credit';
const TRANSACTION_DEBIT = 'debit';
const TRANSACTION_POST = 'pos';

class TransactionType extends FinancialModel
{
    public function getNameAttribute()
    {
        return trans('transaction.'.$this->unique_name);
    }
}
