<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Kalau belum login → lempar ke login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // Kalau role user tidak ada di daftar $roles → 403
        if (! in_array(Auth::user()->role, $roles)) {
            return redirect()->route('dashboard')->withErrors('Unauthorized Access');
        }

        return $next($request);
    }
}

