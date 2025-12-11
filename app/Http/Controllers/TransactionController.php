<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:buyer');
    }
    
    public function index()
    {
        $buyer = Auth::user()->buyer;
        
        if (!$buyer) {
            return redirect('/')->with('error', 'Buyer profile not found');
        }
        
        $transactions = Transaction::with(['store', 'details.product.images'])
            ->where('buyer_id', $buyer->id)
            ->latest()
            ->paginate(10);
        
        return view('transactions.index', compact('transactions'));
    }
    
    public function show($id)
    {
        $buyer = Auth::user()->buyer;
        
        $transaction = Transaction::with([
            'store',
            'details.product.images',
            'details.product.reviews' => function($query) use ($id) {
                $query->where('transaction_id', $id);
            }
        ])
        ->where('buyer_id', $buyer->id)
        ->findOrFail($id);
        
        return view('transactions.show', compact('transaction'));
    }
    
    public function review(Request $request, $id)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);
        
        $buyer = Auth::user()->buyer;
        
        $transaction = Transaction::where('buyer_id', $buyer->id)
            ->where('id', $id)
            ->firstOrFail();
        
        // Check if already reviewed
        $existingReview = ProductReview::where('transaction_id', $id)
            ->where('product_id', $validated['product_id'])
            ->first();
        
        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product');
        }
        
        ProductReview::create([
            'transaction_id' => $id,
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);
        
        return back()->with('success', 'Review submitted successfully!');
    }
}