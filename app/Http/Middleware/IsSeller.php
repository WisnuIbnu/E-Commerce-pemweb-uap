<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsSeller
{
    public function handle($request, Closure $next)
    {
        // Belum login?
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Role bukan seller?
        if (Auth::user()->role !== 'seller') {
            return abort(403, 'You do not have seller access.');
        }

        return $next($request);
    }
}
