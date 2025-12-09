<?php

namespace App\Http\Controllers\Seller; 

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Ambil data toko
        $store = $user->store;

        // Ambil total produk dan pesanan
        $totalProducts = $store->products->count();
        $totalOrders = Order::where('store_id', $store->id)->count();

        return view('seller.dashboard', [
            'store' => $store,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders
        ]);
    }
}

