<?php

namespace App\Http\Controllers\Division\Common;

use App\Division;
use App\Parameter;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function byParameter(Request $request)
    {
        $parameterId = $request->get('parameter_id');
        $parameter = Parameter::findOrFail($parameterId);
        if (!$parameter instanceof Parameter) {
            return abort(500);
        }
        $package = $parameter->getPackage();
        $user = Auth::user();
        if (!$user instanceof User) {
            return abort(500);
        }
        if ($user->hasRole(Role::ROLE_DIVISION_IMMUNOLOGY) && Division::immunology()->hasPackage($package)) {
            return redirect()->route('division.immunology.parameter.statistic', ['id' => $parameter->id]);
        } else if ($user->hasRole(Role::ROLE_DIVISION_HEALTH_CHEMICAL)) {
            return redirect()->route('division.health-chemical.parameter.statistic', ['id' => $parameter->id]);
        } else if ($user->hasRole(Role::ROLE_DIVISION_MICROBIOLOGY)) {
            return redirect()->route('division.microbiology.parameter.statistic', ['id' => $parameter->id]);
        } else if ($user->hasRole(Role::ROLE_DIVISION_PATHOLOGY)) {
            return redirect()->route('division.pathology.parameter.statistic', ['id' => $parameter->id]);
        } else {
            return abort(403);
        }
    }
}
