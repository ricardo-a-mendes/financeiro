<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAccountController extends Controller
{
    public function index()
    {
        return view('layouts.user_account_index');
    }
}
