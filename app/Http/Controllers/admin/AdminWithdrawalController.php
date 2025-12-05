<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class AdminWithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('storeBalance.store')->paginate(20);
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function show(Withdrawal $withdrawal)
    {
        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        $withdrawal->update(['status' => $request->status]);
        return redirect()->back();
    }
}
