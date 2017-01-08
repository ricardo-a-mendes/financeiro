<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalRequest;
use App\Model\Category;
use App\Model\Goal;
use App\Model\TransactionType;
use Session;

class GoalController extends Controller
{

    /**
     * @var Goal
     */
    private $goal;
    /**
     * @var Category
     */
    private $category;
    /**
     * @var TransactionType
     */
    private $transactionType;

    public function __construct(Goal $goal, Category $category, TransactionType $transactionType)
    {
        $this->goal = $goal;
        $this->category = $category;
        $this->transactionType = $transactionType;
    }

    public function index()
    {
        $goals = $this->goal->all();
        return view('layouts.goal_index', compact('goals'));
    }

    public function create()
    {
        $goal = new $this->goal;
        $goal->category()->associate(new $this->category);
        $goal->transactionType()->associate(new $this->transactionType);
        $categories = $this->category->pluck('name', 'id')->all();
        $transactionTypes = $this->transactionType->pluck('name', 'id')->all();
        $method = 'POST';
        $route = route('goal.store');
        return view('layouts.goal_store', compact('goal', 'categories', 'transactionTypes', 'method', 'route'));
    }

    public function store(GoalRequest $request)
    {
        $goal = new $this->goal;

        $category = $this->category->find($request->input('category'));
        $goal->category()->associate($category);

        $transactionType = $this->transactionType->find($request->input('transactionType'));
        $goal->transactionType()->associate($transactionType);

        $goal->value = $request->input('value');

        $goal->save();

        Session::flash('success', 'Meta criada com sucesso!');
        return redirect()->route('goal.index');
    }

    public function edit($id)
    {
        $goal = $this->goal->find($id);
        $categories = $this->category->pluck('name', 'id')->all();
        $transactionTypes = $this->transactionType->pluck('name', 'id')->all();
        $method = 'PUT';
        $route = route('goal.update', ['id' => $id]);
        return view('layouts.goal_store', compact('goal', 'categories', 'transactionTypes', 'method', 'route'));
    }

    public function update(GoalRequest $request, $id)
    {
        $goal = $this->goal->find($id);

        $category = $this->category->find($request->input('category'));
        $goal->category()->associate($category);

        $transactionType = $this->transactionType->find($request->input('transactionType'));
        $goal->transactionType()->associate($transactionType);

        $goal->value = $request->input('value');

        $goal->save();

        Session::flash('success', 'Meta atualizada com sucesso!');
        return redirect()->route('goal.index');
    }

    public function destroy($id)
    {

    }
}
