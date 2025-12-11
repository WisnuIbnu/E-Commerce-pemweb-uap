<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifiedSeller
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Cek apakah role seller
        if ($user->role !== 'seller') {
            return abort(403, 'You are not a seller.');
        }

        // Cek apakah toko sudah diverifikasi admin
        if (!$user->store || !$user->store->is_verified) {
            return redirect()->route('store.notVerified');
        }

        return $next($request);
    }
}
