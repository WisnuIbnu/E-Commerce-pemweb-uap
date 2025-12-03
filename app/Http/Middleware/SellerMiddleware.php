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
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user adalah member
        if (auth()->user()->role !== 'member') {
            abort(403, 'Hanya member yang bisa mengakses halaman seller');
        }

        // Cek apakah user punya toko yang sudah di-ACC
        $hasToko = Store::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->exists();

        if (!$hasToko) {
            return redirect()->route('buyer.dashboard')
                ->with('error', 'Kamu belum punya toko yang disetujui admin. Silakan ajukan toko terlebih dahulu.');
        }

        return $next($request);
    }
}