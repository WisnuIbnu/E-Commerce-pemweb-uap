<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Admin check
        if (in_array('admin', $roles) && $user->role === 'admin') {
            return $next($request);
        }

        // Seller check (member dengan toko verified)
        if (in_array('seller', $roles)) {
            $store = \App\Models\Store::where('user_id', $user->id)
                ->where('is_verified', 1)
                ->first();
            
            if ($store) {
                return $next($request);
            }
            
            // Redirect jika belum punya toko verified
            return redirect()->route('buyer.dashboard')
                ->with('error', 'Anda belum memiliki toko yang terverifikasi.');
        }

        // Member check
        if (in_array('member', $roles) && $user->role === 'member') {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}