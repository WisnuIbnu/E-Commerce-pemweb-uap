<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'userCount'        => User::count(),
            'productCount'     => Product::count(),
            'storeCount'       => Store::count(),
            'transactionCount' => Transaction::count(),
        ]);
    }
}
