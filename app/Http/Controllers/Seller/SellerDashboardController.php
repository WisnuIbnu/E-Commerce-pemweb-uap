<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SellerDashboardController extends Controller
{
    public function index()
    {
        // Ambil toko dari user login
        $store = Store::where('user_id', auth()->id())
                      ->where('is_verified', 1)
                      ->first();

        if (!$store) {
            return redirect()->route('buyer.store.create')
                ->with('error', 'Toko belum tersedia atau belum diverifikasi.');
        }

        // Stats
        $stats = [
            // Total produk berdasarkan store_id
            'total_products' => Product::where('store_id', $store->id)->count(),

            // Total pesanan berdasarkan store_id + relasi produk
            'total_orders' => Transaction::where('store_id', $store->id)
                ->whereHas('transactionDetails', function($q) use ($store) {
                    $q->whereHas('product', function($q2) use ($store) {
                        $q2->where('store_id', $store->id);
                    });
                })->count(),

            // Pending = payment_status unpaid
            'pending_orders' => Transaction::where('store_id', $store->id)
                ->where('payment_status', 'unpaid')
                ->whereHas('transactionDetails', function($q) use ($store) {
                    $q->whereHas('product', function($q2) use ($store) {
                        $q2->where('store_id', $store->id);
                    });
                })->count(),

            // Total revenue = payment_status paid
            'total_revenue' => Transaction::where('store_id', $store->id)
                ->where('payment_status', 'paid')
                ->whereHas('transactionDetails', function($q) use ($store) {
                    $q->whereHas('product', function($q2) use ($store) {
                        $q2->where('store_id', $store->id);
                    });
                })->sum('grand_total'),
        ];

        // Pesanan terbaru
        $recentOrders = Transaction::where('store_id', $store->id)
            ->whereHas('transactionDetails', function($q) use ($store) {
                $q->whereHas('product', function($q2) use ($store) {
                    $q2->where('store_id', $store->id);
                });
            })
            ->latest()
            ->take(5)
            ->get();

        return view('seller.dashboard', compact('stats', 'recentOrders', 'store'));
    }
}
