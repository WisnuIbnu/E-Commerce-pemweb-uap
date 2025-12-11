<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::all();
        $products = Product::with('productImages', 'productCategory');
    
        if ($request->category) {
            $products = $products->where('category_id', $request->category);
        }
    
        $products = $products->paginate(12);
    
        return view('home', compact('products', 'categories'));
    }

    public function category($slug)
    {
        $category = ProductCategory::where('slug', $slug)->firstOrFail();
    
        $products = $category->products()->paginate(12);
    
        $categories = ProductCategory::all();
    
        return view('category', compact('products', 'categories', 'category'));
    }
}
