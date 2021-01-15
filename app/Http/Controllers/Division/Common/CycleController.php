<?php

namespace App\Http\Controllers\Division\Common;

use App\Cycle;
use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CycleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user instanceof User) {
            return abort(500);
        }
        if ($user->hasRole(Role::ROLE_DIVISION_IMMUNOLOGY)) {
            return $this->showIndex('division.immunology.cycle.package.index');
        } else if ($user->hasRole(Role::ROLE_DIVISION_HEALTH_CHEMICAL)) {
            return $this->showIndex('division.health-chemical.cycle.package.index');
        } else if ($user->hasRole(Role::ROLE_DIVISION_MICROBIOLOGY)) {
            return $this->showIndex('division.microbiology.cycle.package.index');
        } else if ($user->hasRole(Role::ROLE_DIVISION_PATHOLOGY)) {
            return $this->showIndex('division.pathology.cycle.package.index');
        } else {
            return abort(403);
        }
    }

    private function showIndex(string $showRouteName)
    {
        $cycles = Cycle::all();
        return view('division.common.cycle.index', [
            'cycles' => $cycles,
            'showRouteName' => $showRouteName,
        ]);
    }
}
