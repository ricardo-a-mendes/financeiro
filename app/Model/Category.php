<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
