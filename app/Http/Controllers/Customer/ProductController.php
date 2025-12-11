<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Homepage
    public function index(Request $request)
    {
        $categories = ProductCategory::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        $productsQuery = Product::with(['productImages', 'productCategory', 'store'])
            ->where('stock', '>', 0)
            ->whereHas('store', function ($query) {
                $query->where('is_verified', true);
            });
        // filter category
        if ($request->filled('category')) {
            $productsQuery->where('product_category_id', $request->category);
        }
        // Search by name
        if ($request->filled('search')) {
            $productsQuery->where('name', 'like', '%' . $request->search . '%');
        }
        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_high':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'name':
                $productsQuery->orderBy('name', 'asc');
                break;
            default:
                $productsQuery->latest();
        }
        $products = $productsQuery->paginate(12);
        return view('customer.home', compact('products', 'categories'));
    }

    // Product detail
    public function show(Product $product)
    {
        // Check if product available
        if ($product->stock <= 0) {
            return redirect()->route('home')
                ->with('error', 'Product is out of stock');
        }

        // Check if store verified
        if (!$product->store->is_verified) {
            return redirect()->route('home')
                ->with('error', 'This product is not available');
        }

        $product->load([
            'productImages',
            'productCategory',
            'productReviews' => function ($query) {
                $query->latest()->with('transaction.buyer.user');
            },
            'store'
        ]);

        // Calculate average rating
        $averageRating = $product->productReviews()->avg('rating') ?? 0;
        $totalReviews = $product->productReviews()->count();
        // Get related products (same category, different product)
        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->whereHas('store', function ($query) {
                $query->where('is_verified', true);
            })
            ->with(['productImages', 'store'])
            ->limit(4)
            ->get();

        return view('customer.product-show', compact(
            'product',
            'averageRating',
            'totalReviews',
            'relatedProducts'
        ));
    }
}
