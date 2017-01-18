<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Model\Category;
use Session;

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
		$categories = $this->category-findAll(Auth::id());
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
		$message = 'Categoria criada com sucesso!';
		$messageAjax = 'Categoria Criada! Você já pode seleciná-la!';
		$messageType = 'success';
		$categoryName = $request->input('category');
		$success = true;
		$existentCategory = $this->category->where('name', $categoryName)->first();
		if (is_null($existentCategory)) {
			$category = new $this->category;
			$category->name = $categoryName;
			$category->save();
		} else {
			$category = $existentCategory;
			$message = $messageAjax = "Categoria '{$categoryName}' já existe!";
			$messageType = 'info';
			$success = false;
		}

		if ($request->ajax())
			return json_encode([
					'success' => $success,
					'category_id' => $category->id,
					'category_name' => $category->name,
					'message' => $messageAjax
				]
			);

		Session::flash($messageType, $message);
		return redirect()->route('category.index');
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
		$category->name = $request->input('category');
		$category->save();

		Session::flash('success', 'Categoria atualizada com sucesso!');
		return redirect()->route('category.index');
	}

	public function destroy($id)
	{
		$category = $this->category->find($id);
		if ($category->transactions->count() == 0) {
			$category->delete();
			Session::flash('success', 'Categoria removida com sucesso!');
		} else {
			Session::flash('info', 'Categoria "'.$category->name.'"" não pode ser excluída: Existem transações vinculadas.');
		}

		return redirect()->route('category.index');
	}

}
