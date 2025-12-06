<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'buyer') {
            return redirect('/')->with('error', 'Only buyers can checkout');
        }
        
        $product = Product::with(['images', 'store'])->findOrFail($request->product_id);
        $quantity = $request->input('quantity', 1);
        
        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Insufficient stock');
        }
        
        $subtotal = $product->price * $quantity;
        
        return view('checkout.index', compact('product', 'quantity', 'subtotal'));
    }
    
    public function process(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'shipping_type' => 'required|in:regular,express',
        ]);
        
        $product = Product::findOrFail($validated['product_id']);
        
        if ($validated['quantity'] > $product->stock) {
            return redirect()->back()->with('error', 'Insufficient stock');
        }
        
        try {
            DB::beginTransaction();
            
            // Get or create buyer
            $buyer = Buyer::firstOrCreate(
                ['user_id' => Auth::id()],
                ['user_id' => Auth::id()]
            );
            
            // Calculate totals
            $subtotal = $product->price * $validated['quantity'];
            $shippingCost = $validated['shipping_type'] === 'express' ? 50000 : 20000;
            $tax = $subtotal * 0.10; // 10% tax
            $grandTotal = $subtotal + $shippingCost + $tax;
            
            // Create transaction
            $transaction = Transaction::create([
                'code' => 'TRX-' . strtoupper(Str::random(10)),
                'buyer_id' => $buyer->id,
                'store_id' => $product->store_id,
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'shipping' => $validated['shipping_type'],
                'shipping_type' => $validated['shipping_type'],
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'payment_status' => 'pending',
            ]);
            
            // Create transaction detail
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'qty' => $validated['quantity'],
                'subtotal' => $subtotal,
            ]);
            
            // Update product stock
            $product->decrement('stock', $validated['quantity']);
            
            DB::commit();
            
            return redirect()->route('transactions.show', $transaction->id)
                ->with('success', 'Order placed successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }
}