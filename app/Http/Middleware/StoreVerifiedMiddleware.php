<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Store;

class StoreVerifiedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $store = Store::where('user_id', auth()->id())->first();

        if (!$store) {
            return redirect()->route('store.register')
                ->with('info', 'Silakan daftarkan toko Anda terlebih dahulu.');
        }

        // Jika toko belum terverifikasi
        if (!$store->is_verified) {
            return redirect()->route('store.pending')
                ->with('info', 'Toko Anda masih menunggu verifikasi admin.');
        }

        return $next($request);
    }
}