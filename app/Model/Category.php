<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public $timestamps = false;

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getCombo()
    {
		//TODO: Get only active categories (replicate to others)
        return $this->pluck('name', 'id')->all();
    }

	public function find($id)
	{
		$category = parent::find($id);
		if (is_null($category))
			$category = parent::find(0);

		return $category;
    }
}
