<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Http\Requests\CreateStoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreController extends Controller
{
    use AuthorizesRequests;
    public function create(Request $request): View
    {
        $this->authorize('create', Store::class);
        return view('store.create');
    }

    public function store(CreateStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Store::class);
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        if($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('store_logo', 'public');
        }
        $data['is_verified'] = 0;
        $store = Store::create($data);
        return Redirect::route('store.edit')->with('status', 'Please wait while our admin verifies your store.');
    }

    public function edit(Request $request): View
    {
        $this->authorize('update', Store::class);
        $store = $request->user()->store;
        return view('store.edit', [
            'store' => $store,
        ]);
    }

    public function update(CreateStoreRequest $request): RedirectResponse
    {
        $this->authorize('update', Store::class);
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        if($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('store_logo', 'public');
        }
        $store = $request->user()->store;
        $store->update($data);
        return Redirect::route('store.edit')->with('status', 'Store profile changes saved.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $this->authorize('delete', Store::class);
        $request->validateWithBag('storeDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $store = $request->user()->store;
        $store->delete();
        return Redirect::to('store.edit')->with('status', 'Store deleted');
    }
}
