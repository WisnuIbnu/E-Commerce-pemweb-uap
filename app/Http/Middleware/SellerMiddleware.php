<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Store;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $store = Store::where('user_id', auth()->id())->first();

        if (!$store && !$request->routeIs('store.register') && !$request->routeIs('store.register.submit')) {
            return redirect()->route('store.register')
                ->with('info', 'Silakan daftarkan toko Anda terlebih dahulu.');
        }

        if ($store && !$store->is_verified && !$request->routeIs('store.pending')) {
            return redirect()->route('store.pending');
        }

        return $next($request);
    }
}