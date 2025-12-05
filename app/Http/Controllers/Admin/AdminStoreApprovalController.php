<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminStoreApprovalController extends Controller
{
    // Menampilkan toko yang diajukan untuk disetujui
    public function index()
    {
        $stores = Store::where('status', 'pending')->get();
        return view('admin.stores.index', compact('stores'));
    }

    // Menyetujui toko
    public function approve($id)
    {
        $store = Store::findOrFail($id);
        $store->status = 'approved'; // Menyetujuinya
        $store->save();

        return redirect()->route('admin.stores.index');
    }

    // Menolak toko
    public function reject($id)
    {
        $store = Store::findOrFail($id);
        $store->status = 'rejected'; // Menolaknya
        $store->save();

        return redirect()->route('admin.stores.index');
    }
}
