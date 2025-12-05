<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan user sudah login dan memiliki role yang sesuai
        if (!auth()->check() || auth()->user()->role !== $role) {
            // Jika tidak, alihkan ke halaman utama atau halaman error
            return redirect('/');
        }

        return $next($request);
    }
}
