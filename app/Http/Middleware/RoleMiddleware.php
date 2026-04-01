<?php

namespace App\Http\Middleware;

use App\Support\RoleMap;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $allowedIds = array_map(static function (string $role): int {
            return RoleMap::idFromName($role);
        }, $roles);

        if (! in_array($user->role, $roles, true) && ! in_array((int) ($user->role_id ?? 0), $allowedIds, true)) {
            abort(403, 'You are not authorized to access this area.');
        }

        return $next($request);
    }
}
