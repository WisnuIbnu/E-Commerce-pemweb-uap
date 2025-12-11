<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserisCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'member') {
            return $next($request);
        }

        abort(403, 'ACCESS DENIED. MEMBER ONLY.');
    }
}