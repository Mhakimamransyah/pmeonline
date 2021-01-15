<?php

namespace App\Http\Controllers\v1\Installation;

use App\Http\Controllers\Controller;

class GraphController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function index()
    {
        return view('v1.installation.graph.index');
    }

}