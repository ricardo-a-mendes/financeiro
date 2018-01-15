<?php

namespace App\Http\Controllers;

use App\Model\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAccountController extends Controller
{
    public function index()
    {
        /** @var Account $account */
        $account = Auth::user()->account;
        $accountUsers = $account->users()->getResults();

        return view('layouts.user_account_index', compact(
            'accountUsers'
        ));
    }
}
