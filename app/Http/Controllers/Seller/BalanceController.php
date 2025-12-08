<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:seller']);
    }

    public function index()
    {
        $store = auth()->user()->store;
        if (! $store) return redirect()->route('seller.store')->with('error','Create store first.');

        $balance = StoreBalance::where('store_id', $store->id)->first();
        $histories = StoreBalanceHistory::where('store_id', $store->id)->latest()->paginate(20);
        $withdrawals = Withdrawal::where('store_id', $store->id)->latest()->paginate(20);

        return view('seller.balance.index', compact('balance','histories','withdrawals'));
    }

    public function withdraw(Request $request)
    {
        $store = auth()->user()->store;
        $request->validate([
            'amount'=>'required|numeric|min:1',
            'bank_name'=>'required|string|max:255',
            'bank_account_name'=>'required|string|max:255',
            'bank_account_number'=>'required|string|max:50',
        ]);

        $balance = StoreBalance::where('store_id',$store->id)->first();
        if (! $balance || $balance->amount < $request->amount) {
            return back()->with('error','Insufficient balance.');
        }

        DB::beginTransaction();
        try {
            // create withdrawal request
            Withdrawal::create([
                'store_id'=>$store->id,
                'amount'=>$request->amount,
                'bank_name'=>$request->bank_name,
                'bank_account_name'=>$request->bank_account_name,
                'bank_account_number'=>$request->bank_account_number,
                'status'=>'pending',
            ]);

            // optionally decrement balance (or wait until admin approves)
            $balance->decrement('amount', $request->amount);

            StoreBalanceHistory::create([
                'store_id'=>$store->id,
                'type'=>'withdraw',
                'amount'=>$request->amount,
                'notes'=>'Withdrawal request created',
            ]);

            DB::commit();
            return back()->with('success','Withdrawal requested.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error','Failed to request withdrawal.');
        }
    }
}
