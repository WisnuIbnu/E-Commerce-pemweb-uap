<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['productCategory', 'store', 'productImages'])
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        // PERBAIKAN: Gunakan where dengan closure untuk grouping OR conditions
        $products = Product::with(['productCategory', 'store', 'productImages', 'productReviews'])
            ->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhereHas('productCategory', function($subQuery) use ($query) {
                      $subQuery->where('name', 'like', '%' . $query . '%');
                  });
            })
            ->where('stock', '>', 0)
            ->paginate(12);

        return view('products.search', compact('products', 'query'));
    }

    public function show($slug)
    {
        $product = Product::with(['productCategory', 'store', 'productImages', 'productReviews'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related products from same category
        $relatedProducts = Product::with(['productCategory', 'store', 'productImages', 'productReviews'])
            ->where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}