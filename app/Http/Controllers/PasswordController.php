<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function show()
    {
        return view('password.show');
    }

    public function update(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { abort(500); }
        return $this->updatePassword($request, $user);
    }

    private function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        $user->setPassword($request->get('password'))
            ->save();
        return redirect()->back()->with(['success' => __('Password berhasil diperbaharui.')]);
    }
}
