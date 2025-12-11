<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\StoreBalanceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        $orders = Transaction::with(['buyer.user', 'details.product'])
            ->where('store_id', $store->id)
            ->latest()
            ->paginate(10);
        
        return view('seller.orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        $store = Auth::user()->store;
        $order = Transaction::with(['buyer.user', 'details.product.images'])
            ->where('store_id', $store->id)
            ->findOrFail($id);
        
        return view('seller.orders.show', compact('order'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);
        
        $store = Auth::user()->store;
        $order = Transaction::where('store_id', $store->id)->findOrFail($id);
        
        DB::beginTransaction();
        try {
            $order->payment_status = $validated['status'];
            $order->save();
            
            // Add balance when order completed
            if ($validated['status'] === 'completed' && $order->payment_status !== 'completed') {
                $storeBalance = $store->balance;
                $storeBalance->increment('balance', $order->grand_total);
                
                StoreBalanceHistory::create([
                    'store_balance_id' => $storeBalance->id,
                    'type' => 'credit',
                    'reference_id' => $order->id,
                    'reference_type' => 'transaction',
                    'amount' => $order->grand_total,
                    'remarks' => 'Payment from order #' . $order->code,
                ]);
            }
            
            DB::commit();
            return back()->with('success', 'Order status updated!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update status');
        }
    }
    
    public function updateShipping(Request $request, $id)
    {
        $validated = $request->validate([
            'tracking_number' => 'required|string|max:255',
        ]);
        
        $store = Auth::user()->store;
        $order = Transaction::where('store_id', $store->id)->findOrFail($id);
        
        $order->tracking_number = $validated['tracking_number'];
        $order->payment_status = 'shipped';
        $order->save();
        
        return back()->with('success', 'Tracking number updated!');
    }
}