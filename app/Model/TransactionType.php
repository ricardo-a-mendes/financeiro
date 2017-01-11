<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

    const TRANSACTION_CREDIT = 'credit';
    const TRANSACTION_DEBIT = 'debit';

class TransactionType extends Model
{
    public function getCombo()
    {
        return $this->pluck('name', 'id')->all();
    }
}
