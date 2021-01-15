<?php

namespace App\Http\Controllers\Division\Common;

use App\Cycle;
use App\Division;
use App\Package;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'installation']);
    }

    public function index($cycleId)
    {
        $user = Auth::user();
        if (!$user instanceof User) {
            return abort(500);
        }
        $division = $user->getRole()->division()->get()->first();
        if ($division == null || !$division instanceof Division) {
            return abort(403);
        }
        $cycle = Cycle::query()->findOrFail($cycleId);
        $packages = $division->packages()->get()->filter(function (Package $package) use ($cycle) {
            return $package->cycle()->get()->first()->is($cycle);
        });
        return view('division.common.package.index', [
            'packages' => $packages,
            'cycle' => $cycle,
        ]);
    }
}
