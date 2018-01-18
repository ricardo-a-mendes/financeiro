<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class FinancialModel extends Model
{
    public function findAll($accountId = 0, $onlyActive = true, $columns = ['*'])
    {
        $builder = $this->newQuery();

        if ($onlyActive && Schema::hasColumn($this->getTable(), 'status'))
            $builder->where('status', 1);

        if ($accountId > 0 && Schema::hasColumn($this->getTable(), 'account_id'))
            $builder->where('account_id', $accountId);

        return $builder->get($columns);
    }

    public function getCombo($identifierField = 'id', $valueField = 'name', $onlyActive = true)
    {
        $builder = $this->newQuery();

        if (Schema::hasColumn($this->getTable(), 'account_id')) {
            $builder->where('account_id', Auth::user()->account->id);
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
