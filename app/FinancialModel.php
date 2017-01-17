<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use League\Flysystem\Exception;

class FinancialModel extends Model
{
    public function getCombo($identifierField = 'id', $valueField = 'name', $onlyActive = true)
    {
		if ($onlyActive && Schema::hasColumn($this->getTable(), 'status'))
			return $this->where('status', 1)->pluck($valueField, $identifierField);

		return $this->pluck($valueField, $identifierField);
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
