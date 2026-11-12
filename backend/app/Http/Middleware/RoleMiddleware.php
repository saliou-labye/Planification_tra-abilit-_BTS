<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /** Usage : ->middleware('role:admin,collecteur') */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $role = $request->user()?->role();

        if (!$role || !in_array($role, $roles, true)) {
            return response()->json(['message' => 'Accès refusé pour votre rôle.'], 403);
        }

        return $next($request);
    }
}