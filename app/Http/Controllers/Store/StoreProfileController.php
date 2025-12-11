<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreProfileController extends Controller
{
    public function edit()
    {
        $store = auth()->user()->store;
        return view('store.profile.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = auth()->user()->store;

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:stores,name,' . $store->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about' => 'required|string|min:50',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ], [
            'name.required' => 'Nama toko harus diisi.',
            'name.unique' => 'Nama toko sudah digunakan.',
            'logo.image' => 'File harus berupa gambar.',
            'logo.mimes' => 'Logo harus berformat: jpeg, png, jpg, gif.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
            'about.required' => 'Deskripsi toko harus diisi.',
            'about.min' => 'Deskripsi toko minimal 50 karakter.',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->except('logo');
            $logoPath = $store->logo;

            if ($request->hasFile('logo')) {
                $uploadPath = public_path('images/stores');
                
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                if ($store->logo && file_exists(public_path($store->logo))) {
                    unlink(public_path($store->logo));
                }

                $logo = $request->file('logo');
                $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();
                $logo->move($uploadPath, $logoName);
                $logoPath = 'images/stores/' . $logoName;
                
                $data['logo'] = $logoPath;
            }

            $store->update($data);

            DB::commit();

            return redirect()->route('store.profile.edit')
                ->with('success', 'Profil toko berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($logoPath) && $logoPath !== $store->logo && file_exists(public_path($logoPath))) {
                unlink(public_path($logoPath));
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy()
    {
        $store = auth()->user()->store;

        $hasPendingOrders = $store->transactions()
            ->whereIn('payment_status', ['pending', 'processing', 'shipped'])
            ->exists();

        if ($hasPendingOrders) {
            return back()->with('error', 'Tidak dapat menghapus toko dengan pesanan yang masih pending');
        }

        DB::beginTransaction();

        try {
            if ($store->logo && file_exists(public_path($store->logo))) {
                unlink(public_path($store->logo));
            }

            $store->delete();

            auth()->user()->update(['role' => 'customer']);

            DB::commit();

            return redirect()->route('home')
                ->with('success', 'Toko berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}