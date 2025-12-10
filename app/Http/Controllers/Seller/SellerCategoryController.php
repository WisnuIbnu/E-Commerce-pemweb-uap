<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Http\Request;

class SellerCategoryController extends Controller
{
    public function index()
    {
        $store = Store::where('user_id', auth()->id())
            ->where('is_verified', 1)
            ->firstOrFail();

        // Ambil kategori yang punya produk milik store ini
        $categories = ProductCategory::whereHas('products', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        })
        ->withCount(['products' => function ($q) use ($store) {
            $q->where('store_id', $store->id);
        }])
        ->latest()
        ->get();

        return view('seller.categories.index', compact('categories', 'store'));
    }

    public function create()
    {
        $store = Store::where('user_id', auth()->id())
            ->where('is_verified', 1)
            ->firstOrFail();

        return view('seller.categories.create', compact('store'));
    }
}
