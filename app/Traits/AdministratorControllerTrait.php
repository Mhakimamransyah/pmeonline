<?php

namespace App\Traits;


use App\Administrator;
use Illuminate\Support\Facades\Auth;

trait AdministratorControllerTrait
{
    /**
     * Get administrator from current user.
     *
     * @return Administrator
     */
    public function findAdministrator()
    {
        return Administrator::where('user_id', '=', Auth::user()->id)->first();
    }

}