<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Transaction;
use App\Models\Buyer;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        // Verify transaction belongs to user
        $buyer = Buyer::where('user_id', auth()->id())->first();

        if (!$buyer) {
            return back()->with('error', 'Buyer profile not found');
        }

        $transaction = Transaction::findOrFail($validated['transaction_id']);

        if ($transaction->buyer_id !== $buyer->id) {
            abort(403, 'Unauthorized action');
        }

        // Check if transaction is paid
        if ($transaction->payment_status !== 'paid') {
            return back()->with('error', 'You can only review after payment');
        }

        // Check if product is in transaction
        $productInTransaction = $transaction->transactionDetails()
            ->where('product_id', $product->id)
            ->exists();

        if (!$productInTransaction) {
            return back()->with('error', 'Product not found in transaction');
        }

        // Check if already reviewed
        $existingReview = ProductReview::where('transaction_id', $transaction->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product');
        }

        // Create review
        ProductReview::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);
        return back()->with('success', 'Review submitted successfully!');
    }

    public function create(Request $request, Product $product)
    {
        $transactionId = $request->query('transaction_id');

        if (!$transactionId) {
            return redirect()->route('transactions.index')
                ->with('error', 'Transaction ID required');
        }

        $buyer = Buyer::where('user_id', auth()->id())->first();

        if (!$buyer) {
            return redirect()->route('home')
                ->with('error', 'Buyer profile not found');
        }

        $transaction = Transaction::where('id', $transactionId)
            ->where('buyer_id', $buyer->id)
            ->where('payment_status', 'paid')
            ->firstOrFail();

        // Check if product is in transaction
        $productInTransaction = $transaction->transactionDetails()
            ->where('product_id', $product->id)
            ->exists();

        if (!$productInTransaction) {
            abort(404, 'Product not found in transaction');
        }

        // Check if already reviewed
        $existingReview = ProductReview::where('transaction_id', $transaction->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return redirect()->route('transactions.show', $transaction)
                ->with('error', 'You have already reviewed this product');
        }
        return view('customer.reviews.create', compact('product', 'transaction'));
    }
}
