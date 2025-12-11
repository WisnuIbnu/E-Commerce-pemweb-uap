<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = ProductCategory::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
                    ->with('productImages', 'productCategory')
                    ->paginate(12);

        $categories = ProductCategory::all();

        return view('home', compact('products', 'categories'));
    }
}
