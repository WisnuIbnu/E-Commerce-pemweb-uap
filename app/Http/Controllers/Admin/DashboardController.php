<?php

// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalStores = Store::count();
        $verifiedStores = Store::where('is_verified', true)->count();
        $pendingStores = Store::where('is_verified', false)->count();
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        
        $recentUsers = User::latest()->limit(5)->get();
        $recentStores = Store::with('user')->latest()->limit(5)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStores',
            'verifiedStores',
            'pendingStores',
            'totalProducts',
            'totalTransactions',
            'recentUsers',
            'recentStores'
        ));
    }
}