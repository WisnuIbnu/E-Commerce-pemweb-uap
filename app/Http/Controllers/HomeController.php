<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller 
{
    public function landing()
    {
        $categories = ProductCategory::take(6)->get();
        $products = Product::latest()->take(8)->get();
        return view('landing', compact('categories','products'));
    }

    public function home()
    {
        $products = Product::latest()->paginate(12);
        return view('user.home.index', compact('products'));
    }
}