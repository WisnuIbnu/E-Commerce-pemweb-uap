<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Data default untuk Member
        $data = [
            'orders_count' => 0, // Nanti relasikan dengan Order
            'favorites_count' => 0,
        ];

        // Data Khusus untuk Seller
        if ($user->role === 'seller' && $user->store) {
            $store = $user->store;
            
            // Mengambil statistik toko
            $data['products_count'] = $store->products()->count();
            // $data['orders_count'] = $store->transactions()->count(); // Jika relasi transaction sudah ada
            $data['store_balance'] = $store->storeBallance->balance ?? 0;
            
            // Ambil 5 pesanan terbaru (Mockup/Placeholder jika belum ada tabel transaksi)
            $data['recent_orders'] = []; // $store->transactions()->latest()->take(5)->get();
        }

        return view('dashboard', $data);
    }
}