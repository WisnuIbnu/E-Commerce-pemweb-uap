<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        // Get all categories
        $categories = ProductCategory::whereNull('parent_id')
            ->with('children')
            ->take(8)
            ->get();

        // Get all products with their relationships
        // SESUAIKAN: category -> productCategory, reviews -> productReviews, thumbnail -> productImages
        $products = Product::with(['productCategory', 'store', 'productImages', 'productReviews'])
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        // Get featured products (products with high ratings)
        // SESUAIKAN: reviews -> productReviews
        $featuredProducts = Product::with(['productCategory', 'store', 'productImages', 'productReviews'])
            ->where('stock', '>', 0)
            ->withAvg('productReviews', 'rating')
            ->orderBy('product_reviews_avg_rating', 'desc')
            ->take(8)
            ->get();

        return view('dashboard', compact('categories', 'products', 'featuredProducts'));
    }

    public function category($slug)
    {
        $category = ProductCategory::where('slug', $slug)->firstOrFail();

        $products = Product::with(['productCategory', 'store', 'productImages', 'productReviews'])
            ->where('product_category_id', $category->id)
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        return view('category', compact('category', 'products'));
    }

}
