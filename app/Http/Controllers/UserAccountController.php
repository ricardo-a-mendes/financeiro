<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Model\Account;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserAccountController extends Controller
{
    use ResetsPasswords;

    public function index()
    {
        /** @var Account $account */
        $account = Auth::user()->account;
        $accountUsers = $account->users()->getResults();

        return view('layouts.user_account_index', compact(
            'accountUsers'
        ));
    }


    public function update(UserRequest $request, $userId)
    {
        /** @var User $user */

        if ($request->has('name')) {
            $user = Auth::user();
            $user->name = $request->get('name');
            $user->save();
        }

        if ($request->has('password')) {
            $user = User::find($userId);
            $this->resetPassword($user, $request->get('password'));
        }

        Session::flash('success', trans('account.messages.updated_successfully'));
        return redirect()->route('my_account.index');
    }
}
