<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerOrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->get();
        
        return view('buyer.orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        $order = auth()->user()->orders()->findOrFail($id);
        
        return view('buyer.orders.show', compact('order'));
    }
    
    public function cancel($id)
    {
        // Logic untuk cancel order
        
        return response()->json(['success' => true]);
    }
    
    public function confirmReceived($id)
    {
        // Logic untuk confirm received
        
        return response()->json(['success' => true]);
    }
}