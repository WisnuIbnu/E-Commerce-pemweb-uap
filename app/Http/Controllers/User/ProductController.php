<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;


use Illuminate\Http\Request;

class ProductController extends Controller
{
    // halaman /products
    public function index(Request $request)
    {
        $query = Product::with(['store', 'category', 'productImages']);

        if ($request->has('category') && in_array($request->category, ['Top', 'Bottom'])) {
            $query->whereHas('category', function ($q) use ($request) {
                // Assuming the category name matches 'Top' or 'Bottom'
                $q->where('name', 'like', '%' . $request->category . '%'); 
            });
        }

        // Filter by Availability
        if ($request->has('availability')) {
            $availabilities = (array) $request->availability;
            
            $query->where(function ($q) use ($availabilities) {
                if (in_array('available', $availabilities)) {
                    $q->orWhere('stock', '>', 0);
                }
                if (in_array('out_of_stock', $availabilities)) {
                    $q->orWhere('stock', '=', 0);
                }
            });
        }

        $products = $query->latest()->paginate(9)->withQueryString();

        return view('user.products.products', compact('products'));
    }

    public function show(Product $product)
    {
        // Load relationships needed for detail page
        $product->load(['store', 'category', 'productImages', 'productReviews']);
        
        return view('user.products.show', compact('product'));
    }
}
