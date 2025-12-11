<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->back()
                ->with('error', 'Anda belum memiliki toko.');
        }

        // Query awal
        $query = Transaction::where('store_id', $store->id)
            ->with(['buyer.user', 'transactionDetails.product']);

        // Filter berdasarkan status pembayaran
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter tracking (resinya)
        if ($request->has('tracking_status')) {
            if ($request->tracking_status == 'unshipped') {
                $query->whereNull('tracking_number');
            } elseif ($request->tracking_status == 'shipped') {
                $query->whereNotNull('tracking_number');
            }
        }

        // Pencarian kode order
        if ($request->has('search') && $request->search != '') {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistik
        $totalOrders = Transaction::where('store_id', $store->id)->count();

        $unpaidOrders = Transaction::where('store_id', $store->id)
            ->whereIn('status', ['pending', 'waiting_payment'])
            ->count();

        $unshippedOrders = Transaction::where('store_id', $store->id)
            ->where('status', 'paid')
            ->whereNull('tracking_number')
            ->count();

        return view('seller.orders.index', compact(
            'store',
            'orders',
            'totalOrders',
            'unpaidOrders',
            'unshippedOrders'
        ));
    }

    public function show($id)
    {
        $store = Auth::user()->store;

        $order = Transaction::where('store_id', $store->id)
            ->with(['buyer.user', 'transactionDetails.product.productImages', 'store'])
            ->findOrFail($id);

        return view('seller.orders.show', compact('store', 'order'));
    }

    /**
     * ✅ UPDATE SHIPPING INFO (Nomor Resi + Kurir)
     */
    public function updateShipping(Request $request, $id)
    {
        $request->validate([
            'shipping' => 'required|string|max:10',
            'tracking_number' => 'required|string|max:100',
        ], [
            'shipping.required' => 'Kurir harus dipilih',
            'tracking_number.required' => 'Nomor resi harus diisi',
        ]);

        try {
            $store = Auth::user()->store;
            $order = Transaction::where('store_id', $store->id)->findOrFail($id);

            // Validasi: Hanya bisa update jika sudah dibayar
            if ($order->status !== 'paid') {
                return redirect()->back()
                    ->with('error', 'Nomor resi hanya dapat diinput untuk pesanan yang sudah dibayar.');
            }

            DB::beginTransaction();

            // Format tracking number: KURIR + Nomor
            // Contoh: JNE12345678 atau sudah lengkap JNE12345678
            $trackingNumber = $request->tracking_number;

            // Jika nomor resi belum ada prefix kurir, tambahkan
            if (!str_starts_with(strtoupper($trackingNumber), strtoupper($request->shipping))) {
                $trackingNumber = strtoupper($request->shipping) . $trackingNumber;
            }

            $order->tracking_number = $trackingNumber;
            $order->save();

            DB::commit();

            return redirect()->back()
                ->with('success', 'Informasi pengiriman berhasil diperbarui! Nomor resi: ' . $trackingNumber);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * LEGACY METHOD - Bisa dihapus jika tidak dipakai
     */
    public function updateTracking(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:100',
            'shipping_type' => 'required|string|max:100',
        ]);

        try {
            $store = Auth::user()->store;
            $order = Transaction::where('store_id', $store->id)->findOrFail($id);

            if ($order->status != 'paid') {
                return redirect()->back()
                    ->with('error', 'Pesanan belum dibayar. Tidak dapat menambahkan nomor resi.');
            }

            DB::beginTransaction();

            $order->tracking_number = $request->tracking_number;
            $order->shipping_type = $request->shipping_type;
            $order->save();

            DB::commit();

            return redirect()->back()
                ->with('success', 'Nomor resi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
