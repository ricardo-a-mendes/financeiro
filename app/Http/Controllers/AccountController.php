<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Model\Account;
use App\Model\AccountType;
use Illuminate\Support\Facades\Auth;
use Session;

class AccountController extends Controller
{

	/**
	 * @var Account
	 */
	private $account;

	/**
	 * @var AccountType
	 */
	private $accountType;

	public function __construct(Account $account, AccountType $accountType)
	{
		$this->account = $account;
		$this->accountType = $accountType;
	}

	public function index()
	{
		$accounts = $this->account->findAll(Auth::id());
		return view('layouts.account_index', compact('accounts'));
    }

	public function create()
	{
		$method = 'POST';
		$route = route('account.store');
		$account = new $this->account;
        $account->accountType()->associate(new $this->accountType);
		$accountTypes = $this->accountType->getCombo('id', 'unique_name');

		return view('layouts.account_store', compact('method', 'route', 'account', 'accountTypes'));
	}

	public function store(AccountRequest $request)
	{
        $account = new $this->account;
        $account->name = $request->input('account');
        $account->user_id = Auth::id();
        $accountType = $this->accountType->find($request->input('type'));
        $account->accountType()->associate($accountType);
		$account->save();

        Session::flash('success', trans('account.messages.created_successfully'));
        return redirect()->route('account.index');
    }

	public function edit($id)
	{
        $method = 'PUT';
        $route = route('account.update', ['id' => $id]);
        $account = $this->account->find($id);
        $accountTypes = $this->accountType->getCombo('id', 'unique_name');

        return view('layouts.account_store', compact('method', 'route', 'account', 'accountTypes'));
    }

	public function update(AccountRequest $request, $id)
	{
        $account = $this->account->find($id);
        $account->name = $request->input('account');
        $accountType = $this->accountType->find($request->input('type'));
        $account->accountType()->associate($accountType);
        $account->save();

        Session::flash('success', trans('account.messages.updated_successfully'));
        return redirect()->route('account.index');
    }

	public function destroy($id)
	{
        //Todo: Implement 'destroy' method (Alter status to "0"')
        /*
        $account = $this->account->find($id);
        if ($account->transactions->count() == 0) {
            $account->delete();
            Session::flash('success', 'Conta removida com sucesso!');
        } else {
            Session::flash('info', 'Conta "'.$account->name.'"" não pode ser excluída: Existem transações vinculadas.');
        }

        return redirect()->route('account.index');
        */
    }
}
