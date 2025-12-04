<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create($transactionId, $productId)
    {
        $transaction = Transaction::where('buyer_id', auth()->id())
            ->where('payment_status', 'delivered')
            ->findOrFail($transactionId);

        $product = Product::findOrFail($productId);

        // Check if already reviewed
        $existingReview = ProductReview::where('transaction_id', $transactionId)
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this product');
        }

        return view('user.review.create', compact('transaction', 'product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        ProductReview::create([
            'transaction_id' => $request->transaction_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('transactions.show', $request->transaction_id)
            ->with('success', 'Review submitted successfully');
    }
}