<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class FinancialModel extends Model
{
    public function findAll($userID = 0, $columns = ['*'])
    {
        $builder = $this->newQuery();
        if ($userID > 0 && Schema::hasColumn($this->getTable(), 'user_id'))
            $builder->where('user_id', 1)//Admin Categories (Everybody must see)
            ->orWhere('user_id', Auth::id());

        return $builder->get($columns);
    }

    public function getCombo($identifierField = 'id', $valueField = 'name', $onlyActive = true)
    {
        $builder = $this->newQuery();

        if (Schema::hasColumn($this->getTable(), 'user_id')) {
            $builder->where('user_id', 1)//Admin Categories (Everybody must see)
            ->orWhere('user_id', Auth::id());
        }

        if ($onlyActive && Schema::hasColumn($this->getTable(), 'status'))
            $builder->where('status', 1);

        return $builder->pluck($valueField, $identifierField);
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
