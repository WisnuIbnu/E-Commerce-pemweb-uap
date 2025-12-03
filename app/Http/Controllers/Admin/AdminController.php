<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalSellers = User::where('role', 'seller')->count();
        $totalProducts = \App\Models\Product::count() ?? 0;
        $totalOrders = \App\Models\Order::count() ?? 0;

        return view('admin.dashboard', compact('totalUsers','totalSellers','totalProducts','totalOrders'));
    }

    public function users()
    {
        $users = User::paginate(12);
        return view('admin.users', compact('users'));
    }
}