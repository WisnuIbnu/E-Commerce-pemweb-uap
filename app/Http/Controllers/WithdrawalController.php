<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\StoreBalance;
use App\Http\Requests\WithdrawalRequest;
use App\Http\Requests\WithdrawalUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WithdrawalController extends Controller
{
    use AuthorizesRequests;
    public function create(Request $request): View
    {
        $this->authorize('create', Withdrawal::class);
        return view('store.withdrawal');
    }

    public function store(WithdrawalRequest $request): RedirectResponse
    {
        $this->authorize('create', Withdrawal::class);
        $data = $request->validated();
        $storeId = auth()->user()->store->id;
        $storeBalance = StoreBalance::where('store_id', $storeId)->first();
        $data['store_balance_id'] = $storeBalance->id;
        $data['status'] = 'pending';
        $withdrawal = Withdrawal::create($data);
        return Redirect::route('withdrawal.edit',  $withdrawal->id)->with('status', 'Please wait while our admin verifies your request.');
    }

    public function edit(Withdrawal $withdrawal): View
    {
        $this->authorize('update', Withdrawal::class);
        return view('store.update-withdrawal', [
            'withdrawal' => $withdrawal,
        ]);
    }

    public function update(WithdrawalUpdateRequest $request, Withdrawal $withdrawal): RedirectResponse
    {
        $this->authorize('update', Withdrawal::class);
        $data = $request->validated();
        $withdrawal->update($data);
        return Redirect::route('withdrawal.create')->with('status', 'Withdrawal changes saved.');
    }
}
