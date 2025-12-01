<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['images', 'category'])
            ->latest()
            ->paginate(12);

        $categories = ProductCategory::all();

        return view('user.home', compact('products', 'categories'));
    }
}
