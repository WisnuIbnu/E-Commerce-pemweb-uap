<?php
// app/Http/Controllers/Seller/OrderController.php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $store = auth()->user()->store;
        
        $query = Transaction::with(['buyer', 'items.product'])
            ->whereHas('items', function($q) use ($store) {
                $q->whereHas('product', function($query) use ($store) {
                    $query->where('store_id', $store->id);
                });
            });

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15);

        return view('seller.orders.index', compact('orders'));
    }

    public function show(Transaction $transaction)
    {
        $store = auth()->user()->store;
        
        // Ensure order contains products from this store
        $hasStoreProducts = $transaction->items()
            ->whereHas('product', function($q) use ($store) {
                $q->where('store_id', $store->id);
            })
            ->exists();

        if (!$hasStoreProducts) {
            abort(403);
        }

        $transaction->load(['buyer', 'items.product.images']);

        return view('seller.orders.show', compact('transaction'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $store = auth()->user()->store;
        
        // Ensure order contains products from this store
        $hasStoreProducts = $transaction->items()
            ->whereHas('product', function($q) use ($store) {
                $q->where('store_id', $store->id);
            })
            ->exists();

        if (!$hasStoreProducts) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:processing,shipped,completed,cancelled'
        ]);

        $transaction->update($validated);

        // If completed, add to store balance
        if ($validated['status'] === 'completed') {
            $storeTotal = $transaction->items()
                ->whereHas('product', function($q) use ($store) {
                    $q->where('store_id', $store->id);
                })
                ->sum('subtotal');

            $store->increment('balance', $storeTotal);
        }

        return redirect()->route('seller.orders.show', $transaction)
            ->with('success', 'Order status updated successfully!');
    }
}
