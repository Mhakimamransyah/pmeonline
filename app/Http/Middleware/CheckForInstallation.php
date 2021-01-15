<?php

namespace App\Http\Middleware;

use App\Role;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckForInstallation
{
    private static $roleNames = [
        Role::ROLE_DIVISION_PATHOLOGY,
        Role::ROLE_DIVISION_IMMUNOLOGY,
        Role::ROLE_DIVISION_MICROBIOLOGY,
        Role::ROLE_DIVISION_HEALTH_CHEMICAL
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user instanceof User) {
            $roleName = $user->getRole()->getName();
            if (in_array($roleName, self::$roleNames)) {
                return $next($request);
            }
            return abort(403);
        }
        return abort(401);
    }
}
