<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class SellerWithdrawController extends Controller
{
    public function index()
    {
        $store = getSellerStore();
        
        // Calculate available balance
        $totalRevenue = \App\Models\Transaction::where('status', 'completed')
            ->whereHas('details', function($q) use ($store) {
                $q->whereHas('product', function($q2) use ($store) {
                    $q2->where('store_id', $store->id);
                });
            })->sum('total_amount');
        
        $totalWithdrawn = $store->withdrawals()
            ->where('status', 'approved')
            ->sum('amount');
        
        $availableBalance = $totalRevenue - $totalWithdrawn;
        
        return view('seller.withdraw.index', compact('store', 'availableBalance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50000',
            'bank_name' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|string',
        ]);

        $store = getSellerStore();
        
        // Check available balance
        $totalRevenue = \App\Models\Transaction::where('status', 'completed')
            ->whereHas('details', function($q) use ($store) {
                $q->whereHas('product', function($q2) use ($store) {
                    $q2->where('store_id', $store->id);
                });
            })->sum('total_amount');
        
        $totalWithdrawn = $store->withdrawals()
            ->where('status', 'approved')
            ->sum('amount');
        
        $availableBalance = $totalRevenue - $totalWithdrawn;
        
        if ($request->amount > $availableBalance) {
            return redirect()->back()
                ->with('error', 'Saldo tidak mencukupi.');
        }

        Withdrawal::create([
            'store_id' => $store->id,
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'status' => 'pending',
        ]);

        return redirect()->route('seller.withdraw.history')
            ->with('success', 'Permintaan penarikan berhasil diajukan.');
    }

    public function history()
    {
        $store = getSellerStore();
        $withdrawals = $store->withdrawals()->latest()->paginate(20);
        
        return view('seller.withdraw.history', compact('store', 'withdrawals'));
    }
}
