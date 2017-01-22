<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProvisionRequest;
use App\Model\Category;
use App\Model\Provision;
use App\Model\ProvisionDate;
use App\Model\TransactionType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class ProvisionController extends Controller
{

    /**
     * @var Provision
     */
    private $provision;
    /**
     * @var Category
     */
    private $category;
    /**
     * @var TransactionType
     */
    private $transactionType;
    /**
     * @var ProvisionDate
     */
    private $provisionDate;

    public function __construct(Provision $provision, ProvisionDate $provisionDate, Category $category, TransactionType $transactionType)
    {
        $this->provision = $provision;
        $this->provisionDate = $provisionDate;
        $this->category = $category;
        $this->transactionType = $transactionType;
    }

    public function index()
    {
        $provisions = $this->provision->findAll(Auth::id());
        return view('provision.index', compact('provisions'));
    }

    public function create()
    {
        $provision = new $this->provision;
        $provision->category()->associate(new $this->category);
        $provision->transactionType()->associate(new $this->transactionType);
        $categories = $this->category->getCombo();
        $transactionTypes = $this->transactionType->getCombo('id', 'unique_name');
        $hasSpecificProvision = 'no';
        $method = 'POST';
        $route = route('provision.store');
        return view('provision.store', compact('provision', 'hasSpecificProvision', 'categories', 'transactionTypes', 'method', 'route'));
    }

    public function store(ProvisionRequest $request)
    {
        $provision = new $this->provision;

        $category = $this->category->find($request->input('category'));
        $provision->category()->associate($category);

        $transactionType = $this->transactionType->find($request->input('transactionType'));
        $provision->transactionType()->associate($transactionType);

        $provision->user_id = Auth::id();
        $provision->value = $request->input('value');

        $provision->save();

        if ($request->has('specific_provision_option') && $request->has('specific_date')) {
            $provisionDate = new ProvisionDate();
            $dateTime = new Carbon($request->input('specific_date'));
            $provisionDate->user_id = Auth::id();
            $provisionDate->target_date = $dateTime->format('Y-m-d');
            $provisionDate->provision()->associate($provision);
            $provisionDate->save();
        }

        Session::flash('success', trans('provision.messages.created_successfully'));
        return redirect()->route('provision.index');
    }

    public function edit($id)
    {
        $provision = $this->provision->find($id);
        $categories = $this->category->getCombo();
        $transactionTypes = $this->transactionType->getCombo('id', 'unique_name');
        $hasSpecificProvision = ($provision->provisionDate->count() > 0) ? 'yes' : 'no';
        $method = 'PUT';
        $route = route('provision.update', ['id' => $id]);
        return view('provision.store', compact('provision', 'hasSpecificProvision', 'categories', 'transactionTypes', 'method', 'route'));
    }

    public function update(ProvisionRequest $request, $id)
    {
        $provision = $this->provision->find($id);

        $category = $this->category->find($request->input('category'));
        $provision->category()->associate($category);

        $transactionType = $this->transactionType->find($request->input('transactionType'));
        $provision->transactionType()->associate($transactionType);

        $provision->value = $request->input('value');

        $provision->save();

        Session::flash('success', trans('provision.messages.updated_successfully'));
        return redirect()->route('provision.index');
    }

    public function destroy($id)
    {
        //Todo: Implement 'destroy' method (Alter status to "0"'
    }
}
