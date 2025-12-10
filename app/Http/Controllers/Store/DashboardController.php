<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the store dashboard
     */
    public function index()
    {
        $store = Store::where('user_id', Auth::id())->first();

        if (!$store) {
            return redirect()->route('store.register')
                ->with('info', 'Anda belum memiliki toko. Daftar sekarang!');
        }

        // Jika belum terverifikasi, redirect ke halaman pending
        if (!$store->is_verified) {
            return redirect()->route('store.pending');
        }

        $store->load(['products', 'balance']);

        // Statistik toko
        $stats = [
            'total_products' => $store->products()->count(),
            'active_products' => $store->products()->where('stock', '>', 0)->count(),
            'total_revenue' => $store->balance->balance ?? 0,
            'pending_orders' => 0, // Bisa ditambahkan logika order nanti
        ];

        return view('store.dashboard', compact('store', 'stats'));
    }
}