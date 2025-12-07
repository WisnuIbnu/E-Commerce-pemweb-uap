<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerCheckoutController extends Controller
{
    public function index()
    {
        // Ambil cart items yang dipilih
        $items = auth()->user()->cartItems ?? collect();
        $subtotal = $items->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        // Ambil addresses
        $addresses = auth()->user()->addresses ?? collect();
        
        return view('buyer.checkout.index', compact('items', 'subtotal', 'addresses'));
    }
    
    public function placeOrder(Request $request)
    {
        // Logic untuk create order
        
        return response()->json(['success' => true, 'order_id' => 1]);
    }
}