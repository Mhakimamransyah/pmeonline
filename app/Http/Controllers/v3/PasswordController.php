<?php

namespace App\Http\Controllers\v3;

use App\Http\Requests\UpdatePasswordRequest;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function update(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { abort(500); }
        $user->setPassword($request->get('password'))
            ->save();
        return response(null, 200);
    }
}
