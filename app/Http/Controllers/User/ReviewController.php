<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Buyer;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a newly created review.
     */
    public function store(Request $request, Product $product)
    {
        // Validate
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['required', 'string', 'max:1000'],
        ]);

        // Get buyer for current user
        $buyer = Buyer::where('user_id', auth()->id())->first();

        if (!$buyer) {
            return redirect()->back()->with('error', 'Buyer profile not found.');
        }

        // Check if user has purchased this product
        $transaction = Transaction::where('buyer_id', $buyer->id)
            ->where('payment_status', 'paid')
            ->whereHas('transactionDetails', function($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->first();

        if (!$transaction) {
            return redirect()->back()->with('error', 'You must purchase this product before reviewing.');
        }

        // Check if user has already reviewed
        $existingReview = ProductReview::whereHas('transaction', function($query) use ($buyer) {
                $query->where('buyer_id', $buyer->id);
            })
            ->where('product_id', $product->id)
            ->exists();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this product.');
        }

        // Create review
        ProductReview::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
