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
     * Usage:
     *    ->middleware(['auth', 'role:admin'])
     *    ->middleware(['auth', 'role:admin,seller'])
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika user belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Jika tidak diberikan role sama sekali, lanjut
        if (empty($roles)) {
            return $next($request);
        }

        // Convert roles yang masuk (bisa "admin,seller") menjadi array utuh
        $allowedRoles = [];

        foreach ($roles as $roleGroup) {
            foreach (explode(',', $roleGroup) as $role) {
                $role = trim($role);
                if ($role !== '') {
                    $allowedRoles[] = $role;
                }
            }
        }

        // Jika role user TIDAK ada dalam daftar role diizinkan
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
