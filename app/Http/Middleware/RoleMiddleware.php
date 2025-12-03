<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Usage in routes:
     *   ->middleware(['auth', 'role:buyer'])
     *   ->middleware(['auth', 'role:admin,seller'])
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika user belum login, kirim ke login
        if (! Auth::check()) {
            return redirect()->route('login');
        }
        
        // Jika tidak ada role yang diberikan pada middleware, biarkan lanjut
        if (empty($roles)) {
            return $next($request);
        }

        // cek apakah user role masuk daftar roles yang diizinkan
        // roles bisa dipanggil sebagai "admin" atau "admin,seller" oleh route
        
        $flat = [];
        foreach ($roles as $r) {
            // jika param berformat "admin,seller" kita pecah juga
            foreach (explode(',', $r) as $part) {
                $part = trim($part);
                if ($part !== '') {
                    $flat[] = $part;
                }
            }
        }

        if (! in_array(Auth::user()->role, $flat)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
