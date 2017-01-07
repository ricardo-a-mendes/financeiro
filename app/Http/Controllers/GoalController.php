<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalRequest;
use App\Model\Goal;

class GoalController extends Controller
{

    /**
     * @var Goal
     */
    private $goal;

    public function __construct(Goal $goal)
    {
        $this->goal = $goal;
    }

	public function index()
	{
        $goals = $this->goal->all();
        return view('layouts.goal_index', compact('goals'));
    }

    public function create()
    {
        $goal = new $this->goal;
        $method = 'POST';
        $route = route('goal.store');
        return view('layouts.goal_store', compact('goal', 'method', 'route'));
    }

    public function store(GoalRequest $request)
    {
        $goal = new $this->goal;
        $goal->value = $request->input('value');
    }

    public function edit($id)
    {
        $goal = $this->goal->find($id);
        $method = 'PUT';
        $route = route('goal.update');
        return view('layouts.goal_store', compact('goal', 'method', 'route'));
    }

    public function update(GoalRequest $request)
    {
        
    }

    public function destroy($id)
    {
        
    }
}
