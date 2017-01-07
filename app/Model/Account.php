<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }
}
