<?php

namespace App\Http\Controllers\v1\Administrator;

use App\Http\Controllers\Controller;
use App\User;
use App\UserAccount;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'superadmin']);
    }

    public function index()
    {
        return view('v1.administrator.account.index');
    }

    public function fetch()
    {
        return UserAccount::with(['roles'])->get();
    }

}
