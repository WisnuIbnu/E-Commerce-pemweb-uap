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
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Memeriksa apakah user sudah login dan memiliki role yang sesuai
        if (Auth::check()) {
            // Cek apakah user memiliki salah satu role yang diberikan dalam middleware
            if (in_array(Auth::user()->role, $roles)) {
                return $next($request); // Lanjutkan request jika role sesuai
            }
        }

        // Redirect jika role tidak sesuai
        return redirect('/home');  // Bisa diarahkan ke halaman lain jika diperlukan
    }
}
