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

        $products = $query->paginate(12); // Changed from get() to paginate()

        return view('user.products.products', compact('products'));
    }

    // halaman /products/{slug}
    public function show(Product $product)
    {
        // Eager load relationships
        $product->load(['productImages', 'store', 'category', 'productReviews.transaction.user']);

        // Calculate average rating
        $averageRating = $product->productReviews()->avg('rating') ?? 0;
        $totalReviews = $product->productReviews()->count();

        // Check if current user has purchased this product
        $hasPurchased = false;
        $canReview = false;
        $hasReviewed = false;

        if (auth()->check()) {
            // Get buyer_id for current user
            $buyer = \App\Models\Buyer::where('user_id', auth()->id())->first();

            if ($buyer) {
                // Check if user has paid transaction with this product
                $hasPurchased = \App\Models\Transaction::where('buyer_id', $buyer->id)
                    ->where('payment_status', 'paid')
                    ->whereHas('transactionDetails', function($query) use ($product) {
                        $query->where('product_id', $product->id);
                    })
                    ->exists();

                // Check if user has already reviewed this product
                $hasReviewed = \App\Models\ProductReview::whereHas('transaction', function($query) use ($buyer) {
                        $query->where('buyer_id', $buyer->id);
                    })
                    ->where('product_id', $product->id)
                    ->exists();

                $canReview = $hasPurchased && !$hasReviewed;
            }
        }

        return view('user.products.show', compact('product', 'averageRating', 'totalReviews', 'canReview', 'hasPurchased', 'hasReviewed'));
    }
}
