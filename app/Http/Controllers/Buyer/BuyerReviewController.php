<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\ProductReview;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerReviewController extends Controller
{
    public function create($transactionId)
    {
        $buyerId = Auth::user()->buyer->id ?? null;

        if (!$buyerId) {
            return redirect()->route('buyer.dashboard')
                ->with('error', 'Data buyer tidak ditemukan');
        }

        $transaction = Transaction::where('buyer_id', $buyerId)
            ->with('transactionDetails.product.images')
            ->findOrFail($transactionId);

        if ($transaction->payment_status !== 'completed') {
            return redirect()->route('buyer.orders.show', $transaction->id)
                ->with('error', 'Pesanan harus sudah selesai untuk memberikan review');
        }

        $existingReviews = ProductReview::where('transaction_id', $transaction->id)->get();

        return view('buyer.review.create', compact('transaction', 'existingReviews'));
    }

    public function store(Request $request, $transactionId)
    {
        $buyerId = Auth::user()->buyer->id ?? null;

        if (!$buyerId) {
            return response()->json([
                'success' => false,
                'message' => 'Data buyer tidak ditemukan'
            ], 401);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000',
        ]);

        try {
            $transaction = Transaction::where('buyer_id', $buyerId)
                ->findOrFail($transactionId);

            if ($transaction->payment_status !== 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus sudah selesai untuk memberikan review'
                ], 422);
            }

            $transactionDetail = $transaction->transactionDetails()
                ->where('product_id', $validated['product_id'])
                ->first();

            if (!$transactionDetail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan di pesanan ini'
                ], 422);
            }

            $existingReview = ProductReview::where('transaction_id', $transaction->id)
                ->where('product_id', $validated['product_id'])
                ->first();

            if ($existingReview) {
                $existingReview->update([
                    'rating' => $validated['rating'],
                    'review' => $validated['review'],
                ]);
                $message = 'Review berhasil diperbarui!';
            } else {
                ProductReview::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $validated['product_id'],
                    'rating' => $validated['rating'],
                    'review' => $validated['review'],
                ]);
                $message = 'Review berhasil ditambahkan!';
            }

            $this->updateProductRating($validated['product_id']);

            return response()->json([
                'success' => true,
                'message' => $message
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function updateProductRating($productId)
    {
        $product = Product::findOrFail($productId);

        $avgRating = ProductReview::where('product_id', $productId)
            ->avg('rating');

        $reviewCount = ProductReview::where('product_id', $productId)
            ->count();

        $product->update([
            'average_rating' => $avgRating ? round($avgRating, 1) : 0,
            'reviews_count' => $reviewCount,
        ]);
    }

    public function productReviews($productId)
    {
        $product = Product::findOrFail($productId);

        $reviews = ProductReview::where('product_id', $productId)
            ->with('transaction.buyer.user')
            ->latest()
            ->paginate(10);

        return view('buyer.review.product-reviews', compact('product', 'reviews'));
    }

    public function destroy($reviewId)
    {
        $buyerId = Auth::user()->buyer->id ?? null;

        if (!$buyerId) {
            return response()->json([
                'success' => false,
                'message' => 'Data buyer tidak ditemukan'
            ], 401);
        }

        try {
            $review = ProductReview::findOrFail($reviewId);

            if ($review->transaction->buyer_id !== $buyerId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak berhak menghapus review ini'
                ], 403);
            }

            $productId = $review->product_id;
            $review->delete();

            $this->updateProductRating($productId);

            return response()->json([
                'success' => true,
                'message' => 'Review berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}