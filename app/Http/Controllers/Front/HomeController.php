<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::all();
        
        $query = Product::with(['productCategory', 'productImages', 'store'])->latest(); 

        if ($request->has('category') && $request->category != null) {
            $query->whereHas('productCategory', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        $products = $query->get();
        
        return view('front.home', compact('categories', 'products'));
    }

    public function show($slug)
    {
    $product = Product::with(['productCategory', 'productImages', 'store', 'productReviews.user']) 
        ->where('slug', $slug)
        ->firstOrFail();

    return view('front.details', compact('product'));
    }
}