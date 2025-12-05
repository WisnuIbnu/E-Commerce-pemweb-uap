<?php
// ============================================
// BuyerProductController.php
// ============================================

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class BuyerProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['store', 'images']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
        
        return view('buyer.products', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with(['store', 'categories', 'images', 'reviews.user'])
            ->findOrFail($id);
        
        // Get related products from same store
        $relatedProducts = Product::where('store_id', $product->store_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
        
        return view('buyer.product-detail', compact('product', 'relatedProducts'));
    }
}