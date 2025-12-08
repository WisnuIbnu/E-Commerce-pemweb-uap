<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    // list products, filter by category & search
    public function index(Request $request)
    {
        $query = Product::with(['images','store','category'])->where('stock','>',0);

        if ($request->filled('q')) {
            $query->where('name','like','%'.$request->q.'%')
                  ->orWhere('description','like','%'.$request->q.'%');
        }

        if ($request->filled('category')) {
            $query->where('product_category_id', $request->category);
        }

        $products = $query->orderByDesc('created_at')->paginate(12)->withQueryString();
        $categories = ProductCategory::all();

        return view('customer.products.index', compact('products','categories'));
    }

    // show product detail by slug
    public function show($slug)
    {
        $product = Product::with(['images','store','category','reviews'])->where('slug',$slug)->firstOrFail();
        return view('customer.products.show', compact('product'));
    }
}
