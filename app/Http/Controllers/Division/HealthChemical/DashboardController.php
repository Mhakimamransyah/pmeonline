<?php

namespace App\Http\Controllers\Division\HealthChemical;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function show()
    {
        return view('division.health-chemical.home');
    }
}
