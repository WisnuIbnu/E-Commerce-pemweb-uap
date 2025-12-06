<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:bank_transfer,credit_card,e-wallet,cod',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        
        try {
            $transaction = Transaction::create([
                'buyer_id' => auth()->id(),
                'total' => 741500, // Demo total
                'status' => 'pending',
                'shipping_address' => $validated['address'] . ', ' . $validated['city'] . ' ' . $validated['postal_code'],
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'] ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('transactions.index')
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to process order. Please try again.');
        }
    }
}