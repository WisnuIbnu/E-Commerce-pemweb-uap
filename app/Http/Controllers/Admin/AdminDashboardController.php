<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use App\Models\Product;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalVerified' => Store::where('status', 'verified')->count(),
            'totalPending'  => Store::where('status', 'pending')->count(),
            'totalUsers'    => User::count(),
            'totalProducts' => Product::count(),
        ]);
    }
}
