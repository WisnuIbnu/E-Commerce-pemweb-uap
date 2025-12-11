<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Only member can access seller panel
        if ($user->role !== 'member') {
            return redirect('/')
                ->with('error', 'Hanya member yang bisa masuk ke dashboard seller.');
        }

        // Load store relation
        $store = $user->store;

        // If no store → redirect to create
        if (!$store) {
            if (!$request->routeIs('seller.store.create') && !$request->routeIs('seller.store.store')) {
                return redirect()->route('seller.store.create')
                    ->with('error', 'Anda harus membuat toko terlebih dahulu.');
            }
            return $next($request);
        }

        // If store exists but not verified (gunakan is_verified, bukan status!)
        if (!$store->is_verified) {
            $allowedRoutes = [
                'seller.dashboard',
                'seller.store.edit',
            ];

            if (!$request->routeIs($allowedRoutes)) {
                return redirect()->route('seller.dashboard')
                    ->with('error', 'Toko Anda belum diverifikasi. Fitur lain akan aktif setelah verifikasi.');
            }
        }

        // All checks passed
        return $next($request);
    }
}
