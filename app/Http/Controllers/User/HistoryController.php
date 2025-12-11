<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(): View
    {
        // Get Buyer ID for current user
        $buyer = \App\Models\Buyer::where('user_id', Auth::id())->first();

        if (!$buyer) {
            $transactions = collect();
        } else {
            $transactions = \App\Models\Transaction::with('store', 'transactionDetails.product.productImages')
                ->where('buyer_id', $buyer->id)
                ->latest()
                ->get();
        }

        return view('user.history.history', compact('transactions'));
    }
}
