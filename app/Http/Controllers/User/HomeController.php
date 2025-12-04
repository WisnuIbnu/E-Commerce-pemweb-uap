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
        $query = Product::with(['store', 'category', 'images'])
            ->where('stock', '>', 0);

        if ($request->has('category')) {
            $query->where('product_category_id', $request->category);
        }

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $products = $query->latest()->paginate(12);
        $categories = ProductCategory::whereNull('parent_id')->get();

        return view('user.home', compact('products', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = Product::with(['store', 'category', 'images'])
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('about', 'like', '%' . $query . '%')
            ->paginate(12);

        return view('user.search', compact('products', 'query'));
    }

    public function categories()
    {
        $categories = ProductCategory::whereNull('parent_id')
            ->withCount('products')
            ->get();

        return view('user.categories', compact('categories'));
    }

    public function category($slug)
    {
        $category = ProductCategory::where('slug', $slug)->firstOrFail();
        $products = $category->products()
            ->with(['store', 'images'])
            ->where('stock', '>', 0)
            ->paginate(12);

        return view('user.category', compact('category', 'products'));
    }
}