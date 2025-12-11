<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\ProductReview;
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

        $products = Product::with(['productCategory', 'store', 'productImages', 'productReviews'])
            ->where(function ($q2) use ($query) {
                $q2->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhereHas('productCategory', function ($subQuery) use ($query) {
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

        $relatedProducts = Product::with(['productCategory', 'store', 'productImages', 'productReviews'])
            ->where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        $hasBought        = false;
        $alreadyReviewed  = false;
        $canReview        = false;

        if (auth()->check() && auth()->user()->role === 'buyer') {
            $userId = auth()->id();

            $hasBought = TransactionDetail::where('product_id', $product->id)
                ->whereHas('transaction', function ($q) use ($userId) {
                    $q->where('payment_status', Transaction::STATUS_PAID)
                      ->whereHas('buyer', function ($qb) use ($userId) {
                          $qb->where('user_id', $userId);
                      });
                })
                ->exists();

            $alreadyReviewed = ProductReview::where('product_id', $product->id)
                ->whereHas('transaction', function ($q) use ($userId) {
                    $q->whereHas('buyer', function ($qb) use ($userId) {
                        $qb->where('user_id', $userId);
                    });
                })
                ->exists();

            $canReview = $hasBought && ! $alreadyReviewed;
        }

        return view('products.show', compact(
            'product',
            'relatedProducts',
            'hasBought',
            'alreadyReviewed',
            'canReview'
        ));
    }
}
