<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images', 'store'])
            ->where('stock', '>', 0);
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('product_category_id', $request->category);
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('about', 'like', '%' . $request->search . '%');
            });
        }
        
        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }
        
        $products = $query->paginate(12);
        $categories = ProductCategory::withCount('products')->get();
        
        return view('products.index', compact('products', 'categories'));
    }
    
    public function show($id)
    {
        $product = Product::with([
            'category',
            'images',
            'store',
            'reviews.buyer.user'
        ])->findOrFail($id);
        
        // Get related products from same category
        $relatedProducts = Product::with(['images'])
            ->where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();
        
        // Calculate average rating
        $averageRating = $product->reviews->avg('rating') ?? 0;
        $totalReviews = $product->reviews->count();
        
        return view('products.show', compact('product', 'relatedProducts', 'averageRating', 'totalReviews'));
    }
}