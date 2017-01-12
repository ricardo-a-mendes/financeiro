<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TransactionReference extends Model
{
	public $timestamps = false;

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function findByDescription($description)
	{
		return $this->where('description', $description)->first();
	}
}
