<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class AdminOrderController extends Controller
{
    public function index()
    {
        $products = Product::paginate(12);
        return view('admin.products', compact('products'));
    }
}