<?php

namespace App\Http\Controllers\Participant;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'participant']);
    }

    public function show()
    {
        return view('participant.profile.show', ['user' => Auth::user()]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        if (!$user instanceof User) { return abort(500); }
        return $this->updateProfile($request, $user);
    }

    private function updateProfile(UpdateProfileRequest $request, User $user)
    {
        $user->fill($request->all())->save();
        return redirect()->back()->with(['success' => __('Profil berhasil diperbaharui.')]);
    }
}
