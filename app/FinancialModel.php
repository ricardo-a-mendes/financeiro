<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialModel extends Model
{
    public function getCombo($optionField = 'id', $valueField = 'name', $onlyActive = true)
    {
        //TODO: Get only active categories (replicate to others)
        return $this->pluck($valueField, $optionField)->all();
    }

    public function findByUniqueName($uniqueName)
    {
        return $this->where('unique_name', $uniqueName)->first();
    }

    public function findByName($name)
    {
        return $this->where('name', $name)->first();
    }
}
