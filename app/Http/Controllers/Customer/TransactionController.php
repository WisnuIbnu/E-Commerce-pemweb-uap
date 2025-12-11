<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Buyer;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory; 
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $buyer = Buyer::where('user_id', auth()->id())->first();
        
        if (!$buyer) {
            return view('customer.transactions.index', [
                'transactions' => collect([])
            ]);
        }

        $transactions = Transaction::where('buyer_id', $buyer->id)
            ->with(['store', 'transactionDetails.product.productImages'])
            ->latest()
            ->paginate(10);

        return view('customer.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        // Check if transaction belongs to current user
        $buyer = Buyer::where('user_id', auth()->id())->first();
        
        if (!$buyer || $transaction->buyer_id !== $buyer->id) {
            abort(403, 'Unauthorized action');
        }

        $transaction->load([
            'store',
            'transactionDetails.product.productImages',
            'productReviews'
        ]);

        // Check which products can be reviewed
        $reviewedProductIds = $transaction->productReviews->pluck('product_id')->toArray();

        return view('customer.transactions.show', compact('transaction', 'reviewedProductIds'));
    }

    public function pay(Transaction $transaction)
    {
        $buyer = Buyer::where('user_id', auth()->id())->first();
        
        if (!$buyer || $transaction->buyer_id !== $buyer->id) {
            abort(403, 'Unauthorized action');
        }

        if ($transaction->payment_status === 'paid') {
            return back()->with('error', 'Transaction already paid');
        }

        $transaction->update(['payment_status' => 'paid']);

        // Add to store balance
        $storeBalance = StoreBalance::firstOrCreate(
            ['store_id' => $transaction->store_id],
            ['balance' => 0]
        );

        $storeBalance->increment('balance', $transaction->grand_total);

        // Record balance history
        StoreBalanceHistory::create([
            'store_balance_id' => $storeBalance->id,
            'type' => 'income',
            'reference_id' => (string)$transaction->id,
            'reference_type' => 'transaction',
            'amount' => $transaction->grand_total,
            'remarks' => 'Payment from transaction ' . $transaction->code,
        ]);

        return back()->with('success', 'Payment successful!');
    }
}
