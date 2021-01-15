<?php

namespace App\Http\Controllers\Division\Pathology;

use App\Http\Controllers\Controller;
use App\Parameter;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function show()
    {
        return view('division.pathology.home');
    }
}
