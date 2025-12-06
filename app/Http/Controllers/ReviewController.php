<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Thank you for your review!');
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully!');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }
}