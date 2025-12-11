<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;

class HomeController extends Controller 
{
    public function landing()
    {
        $categories = ProductCategory::take(6)->get();
        $products = Product::latest()->take(8)->get();
        $featuredStore = Store::find(2);
        return view('landing', compact('categories','products','featuredStore'));
    }

    public function home()
    {
        $products = Product::latest()->paginate(12);
        return view('user.home.index', compact('products'));
    }
}