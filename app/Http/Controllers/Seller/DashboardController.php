<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        
        if (!$store) {
            return redirect('/seller/store/register')
                ->with('error', 'Please register your store first');
        }
        
        // Statistics
        $totalProducts = Product::where('store_id', $store->id)->count();
        $totalOrders = Transaction::where('store_id', $store->id)->count();
        $pendingOrders = Transaction::where('store_id', $store->id)
            ->where('payment_status', 'pending')
            ->count();
        
        $balance = $store->balance ? $store->balance->balance : 0;
        
        // Recent orders
        $recentOrders = Transaction::with(['buyer.user', 'details.product'])
            ->where('store_id', $store->id)
            ->latest()
            ->limit(5)
            ->get();
        
        // Top products
        $topProducts = Product::where('store_id', $store->id)
            ->withCount('transactionDetails')
            ->orderBy('transaction_details_count', 'desc')
            ->limit(5)
            ->get();
        
        return view('seller.dashboard', compact(
            'store', 
            'totalProducts', 
            'totalOrders', 
            'pendingOrders', 
            'balance', 
            'recentOrders',
            'topProducts'
        ));
    }
}