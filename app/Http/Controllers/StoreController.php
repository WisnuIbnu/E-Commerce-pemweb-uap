<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Http\Requests\CreateStoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function create(Request $request): View
    {
        return view('store.create');
    }

    public function store(CreateStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['logo'] = $request->file('logo')->store('store_logo', 'public');
        $data['is_verified'] = 0;
        $store = Store::create($data);
        return Redirect::route('store.create')->with('status', 'store-created');
    }

    public function edit(Request $request): View
    {
        $store = $request->user()->store;
        if ($store && $store->is_verified == 0) {
            session()->flash('warning', 'Your store has not been verified by admin.');
        }
        return view('store.edit', [
            'store' => $store,
        ]);
    }

    public function update(CreateStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['logo'] = $request->file('logo')->store('store_logo', 'public');;
        $store = $request->user()->store;
        $store->update($data);
        return Redirect::route('store.edit')->with('status', 'store-updated');
    }
}
