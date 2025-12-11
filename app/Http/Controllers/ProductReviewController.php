<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if (!Auth::check() || Auth::user()->role !== 'buyer') {
            abort(403, 'Hanya pembeli yang boleh memberikan ulasan.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['required', 'string', 'max:2000'],
        ]);

        $userId = Auth::id();

        $detail = TransactionDetail::where('product_id', $product->id)
            ->whereHas('transaction', function ($q) use ($userId) {
                $q->where('payment_status', Transaction::STATUS_PAID)
                  ->whereHas('buyer', function ($qb) use ($userId) {
                      $qb->where('user_id', $userId);
                  });
            })
            ->latest()
            ->first();

        if (!$detail) {
            return back()->withErrors([
                'review' => 'Anda belum pernah membeli produk ini, sehingga tidak dapat memberikan ulasan.',
            ]);
        }

        $hasReviewed = ProductReview::where('product_id', $product->id)
            ->where('transaction_id', $detail->transaction_id)
            ->exists();

        if ($hasReviewed) {
            return back()->withErrors([
                'review' => 'Anda sudah memberikan ulasan untuk pembelian produk ini.',
            ]);
        }

        // Simpan ulasan
        ProductReview::create([
            'transaction_id' => $detail->transaction_id,
            'product_id'     => $product->id,
            'rating'         => $validated['rating'],
            'review'         => $validated['review'],
        ]);

        return back()->with('success', 'Terima kasih, ulasan kamu berhasil dikirim.');
    }
}
