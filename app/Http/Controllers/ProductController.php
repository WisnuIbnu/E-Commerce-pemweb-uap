<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->with([
                'productCategory',
                'productImages',
            ]);

        // Filter berdasarkan kategori (berdasarkan product_category_id)
        if ($request->filled('category')) {
            $query->where('product_category_id', $request->category);
        }

        // Search berdasarkan nama
        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;

                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;

                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // default sort jika tidak ada parameter sort
            $query->orderBy('created_at', 'desc');
        }

        // JANGAN latest() lagi, supaya sort di atas tetap kepakai
        $products   = $query->paginate(12);
        $categories = ProductCategory::all();

        return view('dashboard', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::with([
                'productCategory',
                'productImages',
                'productReviews',
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('product', compact('product'));
    }

    public function welcome(Request $request)
    {
        $query = Product::query()
            ->with([
                'productCategory',
                'productImages',
            ]);

        if ($request->filled('category')) {
            $query->where('product_category_id', $request->category);
        }
        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;

                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;

                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products   = $query->paginate(12);
        $categories = ProductCategory::all();

        return view('welcome', compact('products', 'categories'));
    }
}