<?php

namespace App\Model;

use App\FinancialModel;

class TransactionReference extends FinancialModel
{
	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function findByDescription($description)
	{
		return $this->where('description', $description)->first();
	}
}
