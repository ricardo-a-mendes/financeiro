<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Model\Account;
use App\Model\AccountType;
use Illuminate\Http\Request;

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
		$accounts = $this->account->all();
		return view('layouts.account_index', compact('accounts'));
    }

	public function create()
	{
		$method = 'POST';
		$route = route('account.store');
		$account = new $this->account;
		$accountTypes = $this->accountType->pluck('description', 'id')->all();

		return view('layouts.account_store', compact('method', 'route', 'account', 'accountTypes'));
	}

	public function store(AccountRequest $request)
	{
		dd($request);
    }

	public function edit($id)
	{
        $method = 'PUT';
        $route = route('account.store');
        $account = $this->account->find($id);
        $accountTypes = $this->accountType->pluck('description', 'id')->all();

        return view('layouts.account_store', compact('method', 'route', 'account', 'accountTypes'));
    }

	public function update(AccountRequest $request)
	{

    }

	public function destroy($id)
	{

    }
}
