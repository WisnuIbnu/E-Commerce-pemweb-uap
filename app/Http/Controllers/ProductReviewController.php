<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:5|max:1000',
        ]);

        $user = Auth::user();
        if (!$user->buyer) {
            return back()->with('error', 'You must complete your profile before reviewing.');
        }

        // Find a valid transaction for this product by this user
        // We look for a TransactionDetail for this product where the parent Transaction belongs to the user
        $transaction = Transaction::where('buyer_id', $user->buyer->id)
            ->whereHas('details', function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            // Optional: Check status if you want to restrict to 'completed'
            // ->where('status', 'completed') 
            ->first();

        if (!$transaction) {
            return back()->with('error', 'You can only review products you have purchased.');
        }

        // Check if review already exists for this transaction and product
        $existingReview = ProductReview::where('transaction_id', $transaction->id)
            ->where('product_id', $request->product_id)
            ->exists();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product for this purchase.');
        }

        ProductReview::create([
            'transaction_id' => $transaction->id, // Use the transaction ID we found
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}
