<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    /**
     * Get paginated reviews for a product (AJAX endpoint)
     * Returns JSON with reviews, average rating, and total count
     * 
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Product $product)
    {
        $perPage = 5;
        $page = request()->get('page', 1);

        // Get paginated reviews with buyer information
        // ADJUST: Sesuaikan join dengan struktur table Anda
        // Jika menggunakan table 'users', ganti 'buyers' dengan 'users'
        $reviews = DB::table('product_reviews')
            ->leftJoin('transactions', 'product_reviews.transaction_id', '=', 'transactions.id')
            ->leftJoin('buyers', 'transactions.buyer_id', '=', 'buyers.id') // Atau 'users' jika pakai table users
            ->where('product_reviews.product_id', $product->id)
            ->select(
                'product_reviews.id',
                'product_reviews.rating',
                'product_reviews.review',
                'product_reviews.created_at',
                DB::raw('COALESCE(buyers.name, "Anonymous") as user_name') // Sesuaikan field name
            )
            ->orderBy('product_reviews.created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        // Calculate average rating and total reviews
        $avgRating = DB::table('product_reviews')
            ->where('product_id', $product->id)
            ->avg('rating');
        
        $totalReviews = DB::table('product_reviews')
            ->where('product_id', $product->id)
            ->count();

        // Format the response
        $data = $reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'rating' => $review->rating,
                'review' => $review->review,
                'user_name' => $review->user_name,
                'created_at' => \Carbon\Carbon::parse($review->created_at)->format('d M Y'),
                'created_at_human' => \Carbon\Carbon::parse($review->created_at)->diffForHumans(),
            ];
        });

        return response()->json([
            'avg_rating' => round($avgRating ?? 0, 1),
            'total' => $totalReviews,
            'per_page' => $perPage,
            'current_page' => $reviews->currentPage(),
            'last_page' => $reviews->lastPage(),
            'data' => $data,
        ]);
    }

    /**
     * Store a new review (AJAX endpoint, requires authentication)
     * 
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Product $product)
    {
        // Validate input
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|max:1000',
            'transaction_id' => 'nullable|exists:transactions,id', // Optional
        ]);

        // OPTIONAL: Check if user has purchased this product
        // Uncomment dan sesuaikan dengan struktur table Anda
        /*
        $hasPurchased = DB::table('transactions')
            ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->where('transactions.buyer_id', Auth::id()) // Atau user_id
            ->where('transaction_details.product_id', $product->id)
            ->where('transactions.status', 'completed') // Sesuaikan status
            ->exists();

        if (!$hasPurchased) {
            return response()->json([
                'success' => false,
                'message' => 'Anda hanya bisa memberikan review untuk produk yang sudah dibeli.'
            ], 403);
        }
        */

        // Check if user already reviewed this product (optional: prevent duplicate)
        $existingReview = DB::table('product_reviews')
            ->join('transactions', 'product_reviews.transaction_id', '=', 'transactions.id')
            ->where('transactions.buyer_id', Auth::id()) // Sesuaikan dengan struktur
            ->where('product_reviews.product_id', $product->id)
            ->exists();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan review untuk produk ini.'
            ], 422);
        }

        // Get transaction_id if provided, or find user's transaction for this product
        $transactionId = $validated['transaction_id'] ?? null;
        
        if (!$transactionId) {
            // Try to find a transaction for this user with this product
            $transactionId = DB::table('transactions')
                ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
                ->where('transactions.buyer_id', Auth::id())
                ->where('transaction_details.product_id', $product->id)
                ->value('transactions.id');
        }

        // Insert review
        $reviewId = DB::table('product_reviews')->insertGetId([
            'transaction_id' => $transactionId,
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Get updated stats
        $avgRating = DB::table('product_reviews')
            ->where('product_id', $product->id)
            ->avg('rating');
        
        $totalReviews = DB::table('product_reviews')
            ->where('product_id', $product->id)
            ->count();

        // Get the created review with user info
        $createdReview = DB::table('product_reviews')
            ->leftJoin('transactions', 'product_reviews.transaction_id', '=', 'transactions.id')
            ->leftJoin('buyers', 'transactions.buyer_id', '=', 'buyers.id')
            ->where('product_reviews.id', $reviewId)
            ->select(
                'product_reviews.id',
                'product_reviews.rating',
                'product_reviews.review',
                'product_reviews.created_at',
                DB::raw('COALESCE(buyers.name, "Anonymous") as user_name')
            )
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil ditambahkan!',
            'review' => [
                'id' => $createdReview->id,
                'rating' => $createdReview->rating,
                'review' => $createdReview->review,
                'user_name' => $createdReview->user_name,
                'created_at' => \Carbon\Carbon::parse($createdReview->created_at)->format('d M Y'),
                'created_at_human' => \Carbon\Carbon::parse($createdReview->created_at)->diffForHumans(),
            ],
            'avg_rating' => round($avgRating, 1),
            'total' => $totalReviews,
        ]);
    }

    /**
     * Delete a review (Admin only - implement middleware)
     * Uncomment dan tambahkan route jika diperlukan
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    /*
    public function destroy($id)
    {
        // TODO: Add admin authorization check
        // if (!Auth::user()->isAdmin()) { return response()->json(['error' => 'Unauthorized'], 403); }
        
        $deleted = DB::table('product_reviews')->where('id', $id)->delete();
        
        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Review berhasil dihapus.']);
        }
        
        return response()->json(['success' => false, 'message' => 'Review tidak ditemukan.'], 404);
    }
    */
}