<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        if ($user instanceof User) {
            if ($user->isAdministrator()) {
                return redirect('/administrator');
            } else if ($user->isParticipant()) {
                return redirect('/participant');
            } else if ($user->isInstallation()) {
                return redirect('/instalasi');
            } else {
                return abort(403);
            }
        } else {
            return abort(500);
        }
    }

    public function asAdministrator()
    {
        return view('administrator.home');
    }

    public function asParticipant()
    {
        return view('participant.home');
    }
}
