<?php

namespace App\Http\Controllers\v1\Base;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $administratorFunctions = [];

    public function __construct()
    {
        $this->middleware(['auth', 'administrator'])->only($this->administratorFunctions);
    }
}