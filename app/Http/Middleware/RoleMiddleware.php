<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        foreach ($roles as $role) {
            $role = strtolower(trim($role));

            if ($role === 'admin' && $user->isAdmin()) {
                return $next($request);
            }

            if ($role === 'member' && $user->isMember()) {
                return $next($request);
            }
        }

        abort(403);
    }
}
