<?php

namespace App\Http\Controllers\v1\Installation;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('installation');
    }

    public function show()
    {
        return view('v1.home');
    }

}