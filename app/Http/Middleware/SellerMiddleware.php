<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Store;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has approved store
        $store = Store::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        if (!$store) {
            return redirect()->route('buyer.home')->with('error', 'Anda belum memiliki toko yang disetujui. Silakan ajukan toko terlebih dahulu.');
        }

        // Store the store info in request for easy access
        $request->attributes->add(['seller_store' => $store]);

        return $next($request);
    }
}