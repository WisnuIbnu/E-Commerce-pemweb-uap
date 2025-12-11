<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\StoreBalance;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $store = auth()->user()->store;

        $query = Transaction::whereHas('transactionDetails.product', function($q) use ($store) {
            $q->where('store_id', $store->id);
        })->with([
            'buyer.user',
            'transactionDetails.product'
        ]);

        if ($request->has('status') && $request->status != '') {
            $query->where('payment_status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('store.order.index', compact('orders'));
    }

    public function show($id)
    {
        $store = auth()->user()->store;

        $order = Transaction::whereHas('transactionDetails.product', function($q) use ($store) {
            $q->where('store_id', $store->id);
        })->with([
            'buyer.user',
            'transactionDetails.product.images'
        ])
        ->findOrFail($id);

        return view('store.order.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $store = auth()->user()->store;

        $order = Transaction::whereHas('transactionDetails.product', function($q) use ($store) {
            $q->where('store_id', $store->id);
        })->findOrFail($id);

        $oldStatus = $order->payment_status;
        $newStatus = $request->status;

        // Update status
        $order->update(['payment_status' => $newStatus]);

        // Jika status berubah menjadi paid atau delivered, tambahkan saldo
        if (in_array($newStatus, ['paid', 'delivered']) && !in_array($oldStatus, ['paid', 'delivered'])) {
            $this->addBalanceToStore($order, $store);
        }

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    public function updateTracking(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:100',
        ]);

        $store = auth()->user()->store;

        $order = Transaction::whereHas('transactionDetails.product', function($q) use ($store) {
            $q->where('store_id', $store->id);
        })->findOrFail($id);

        $order->update([
            'tracking_number' => $request->tracking_number,
            'payment_status' => 'shipped',
        ]);

        return redirect()->back()->with('success', 'Tracking number added successfully');
    }

    /**
     * Tambahkan saldo ke store ketika order paid/delivered
     */
    protected function addBalanceToStore($transaction, $store)
    {
        $storeEarning = 0;
        
        foreach ($transaction->transactionDetails as $detail) {
            if ($detail->product && $detail->product->store_id == $store->id) {
                $storeEarning += $detail->subtotal;
            }
        }

        if ($storeEarning > 0) {
            $balance = StoreBalance::firstOrCreate(
                ['store_id' => $store->id],
                ['balance' => 0]
            );

            $existingHistory = $balance->history()
                ->where('reference_type', 'App\Models\Transaction')
                ->where('reference_id', $transaction->id)
                ->where('type', 'income')
                ->exists();

            if (!$existingHistory) {
                $balance->addBalance(
                    $storeEarning,
                    'App\Models\Transaction',
                    $transaction->id,
                    'Order #' . $transaction->code . ' completed'
                );
            }
        }
    }
}