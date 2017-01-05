<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Model\Category;

class CategoryController extends Controller
{

	/**
	 * @var Category
	 */
	private $category;

	public function __construct(Category $category)
	{
		$this->category = $category;
	}

	public function index()
	{
		$categories = $this->category->all();
		return view('layouts.category_index', compact('categories'));
    }

	public function create()
	{
		$category = new $this->category;
		$route = route('category.store');
		$method = 'POST';
		return view('layouts.category_store', compact('category', 'route', 'method'));
	}

	public function store(CategoryRequest $request)
	{

	}

	public function edit($id)
	{
		$category = $this->category->find($id);
		$route = route('category.update', ['id' => $id]);
		$method = 'PUT';
		return view('layouts.category_store', compact('category', 'route', 'method'));
    }

	public function update(CategoryRequest $request, $id)
	{
		$category = $this->category->find($id);
		$category->description = $request->input('category');
		$category->save();

		return redirect()->route('category.index');
    }

}
