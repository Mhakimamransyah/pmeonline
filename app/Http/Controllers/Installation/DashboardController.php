<?php

namespace App\Http\Controllers\Installation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function index()
    {
        return view('instalasi.home');
    }
}
