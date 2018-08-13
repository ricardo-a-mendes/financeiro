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

/**
 * Class ProvisionController
 * @package App\Http\Controllers
 */
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
        $accountId = Auth::user()->account->id;
        $provisions = $this->provision->findAll($accountId);
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
        return view('provision.store_new', compact('provision', 'hasSpecificProvision', 'categories', 'transactionTypes', 'method', 'route'));
    }

    public function store(ProvisionRequest $request)
    {
        $provision = new $this->provision;

        $category = $this->category->find($request->input('category'));
        $provision->category()->associate($category);

        $transactionType = $this->transactionType->find($request->input('transactionType'));
        $provision->transactionType()->associate($transactionType);

        $provision->account_id = Auth::user()->account->id;
        $provision->user_id = Auth::id();
        $provision->value = $request->input('value');

        $provision->save();

        Session::flash('success', trans('provision.messages.created_successfully'));
        return redirect()->route('provision.index');
    }

    public function edit($id)
    {
        $provision = $this->provision->find($id);
        if (Auth::user()->cannot('update', $provision)) {
            echo 'sem acesso';
            die;
        }
        $categories = $this->category->getCombo();
        $transactionTypes = $this->transactionType->getCombo('id', 'unique_name');
        $method = 'PUT';
        $route = route('provision.update', ['id' => $id]);
        return view('provision.store_existent', compact('provision', 'categories', 'transactionTypes', 'method', 'route'));
    }

    public function update(ProvisionRequest $request, $id)
    {
        $currentProvision = $this->provision->find($id);
        $currentValidUntil = Carbon::createFromTimestamp(strtotime('-1 month'));
        $currentProvision->valid_until = $currentValidUntil->format('Y-m-t');
        $currentProvision->save();

        $provision = new $this->provision;
        $category = $this->category->find($request->input('category'));
        $provision->category()->associate($category);

        $transactionType = $this->transactionType->find($request->input('transactionType'));
        $provision->transactionType()->associate($transactionType);

        $provision->account_id = Auth::user()->account->id;
        $provision->user_id = Auth::id();
        $provision->value = $request->input('value');

        $startAt = Carbon::createFromFormat('Y-m', $request->input('start_at'));
        $startAt->day = 1;

        $validUntil = Carbon::createFromFormat('Y-m', $request->input('valid_until'));
        $validUntil->day = $validUntil->format('t');

        $provision->start_at = $startAt->format('Y-m-d');
        $provision->valid_until = $validUntil->format('Y-m-d');

        $provision->save();

        Session::flash('success', trans('provision.messages.updated_successfully'));
        return redirect()->route('provision.index');
    }

    public function specificProvision($provisionID)
    {
        $accountId = Auth::user()->account->id;

        //TODO: Criar funcao para mostrar a data de acordo com a liguagem do abimente - apresentacao na view
        $provisions = $this->provision
            ->select('provisions.value', 'provisions.created_at', 'null as target_date')
            //->select('provisions.*')
            //->join('provision_dates', 'provision_dates.provision_id', '=', 'provisions.id')
            ->where('provisions.id', $provisionID)
            ->where('provisions.account_id', $accountId)
            //->where('provision_dates.account_id', $accountId)
            ->get();

        return view('provision.specific_details', compact('provisions'));
    }

    public function destroy($id)
    {
        //Todo: Implement 'destroy' method (Alter status to "0"'
    }
}
