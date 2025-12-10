@extends('layouts.seller')

@section('title', 'Detail Pesanan')
@section('subtitle', 'Perbarui status pesanan dan masukkan nomor pelacakan.')

@section('seller-content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    {{-- Kolom Kiri: Detail Pesanan --}}
    <div class="lg:col-span-2 space-y-6">
        
        {{-- Card: Produk & Pembeli --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Ringkasan Pesanan #{{ $orderDetail->transaction->code ?? 'N/A' }}</h3>
            
            <div class="flex gap-4 border-b border-slate-100 pb-4 mb-4">
                <div class="w-20 h-20 rounded-lg bg-slate-50 overflow-hidden flex-shrink-0">
                    {{-- Ganti dengan thumbnail produk --}}
                    {{-- <img src="{{ asset('storage/' . $orderDetail->product->thumbnail) }}" class="w-full h-full object-cover"> --}}
                </div>
                <div>
                    <p class="font-bold text-slate-900 line-clamp-2">{{ $orderDetail->product->name ?? 'Produk Dihapus' }}</p>
                    <p class="text-sm text-slate-600 mt-1">QTY: {{ $orderDetail->quantity }} x Rp {{ number_format($orderDetail->price, 0, ',', '.') }}</p>
                    <p class="text-sm font-bold text-primary mt-1">Total: Rp {{ number_format($orderDetail->price * $orderDetail->quantity, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Nama Pembeli:</span>
                    <span class="font-semibold text-slate-800">{{ $orderDetail->transaction->buyer->user->name ?? 'Pengguna' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Tanggal Pesan:</span>
                    <span class="font-semibold text-slate-800">{{ $orderDetail->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Alamat Pengiriman:</span>
                    <span class="font-semibold text-slate-800 text-right max-w-xs">{{ $orderDetail->transaction->address ?? 'Alamat tidak ditemukan' }}</span>
                </div>
            </div>
        </div>
        
        {{-- Card: Histori Pesanan (Placeholder) --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Log Aktivitas</h3>
            <div class="text-slate-500 text-sm italic">
                Aktivitas pesanan (Misal: Diproses admin, diterima pembeli) akan muncul di sini.
            </div>
        </div>
    </div>
    
    {{-- Kolom Kanan: Form Update --}}
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200 sticky top-28">
            <h3 class="text-lg font-bold text-slate-900 mb-5">Update Status</h3>
            
            <form action="{{ route('seller.orders.update', $orderDetail->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                {{-- Status --}}
                <div class="mb-4">
                    <label for="status" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Status Pesanan</label>
                    <select name="status" id="status" class="w-full rounded-xl border-2 border-slate-300 focus:border-primary focus:ring-primary text-sm bg-white shadow-sm p-3 transition-all">
                        <option value="pending" {{ $orderDetail->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Pembayaran)</option>
                        <option value="processing" {{ $orderDetail->status == 'processing' ? 'selected' : '' }}>Processing (Siap Dikirim)</option>
                        <option value="shipping" {{ $orderDetail->status == 'shipping' ? 'selected' : '' }}>Shipping (Sedang Dikirim)</option>
                        <option value="delivered" {{ $orderDetail->status == 'delivered' ? 'selected' : '' }}>Delivered (Selesai)</option>
                        <option value="cancelled" {{ $orderDetail->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                {{-- Nomor Resi --}}
                <div class="mb-6">
                    <label for="shipping_code" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Nomor Resi / Pelacakan</label>
                    <input type="text" name="shipping_code" id="shipping_code" value="{{ old('shipping_code', $orderDetail->shipping_code) }}" 
                        class="w-full rounded-full border-2 border-slate-300 focus:border-primary focus:ring-primary text-sm bg-white shadow-sm h-12 px-4 placeholder-slate-400 transition-all"
                        placeholder="Masukkan nomor resi">
                    @error('shipping_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                {{-- Tombol Submit --}}
                <button type="submit" class="w-full py-3 bg-primary hover:bg-primary-dark text-white font-bold rounded-full transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-rotate"></i> Update Pesanan
                </button>
                
                <a href="{{ route('seller.orders.index') }}" class="block text-center mt-4 text-sm text-slate-500 hover:text-slate-800">
                    Kembali ke Daftar Pesanan
                </a>
            </form>
        </div>
    </div>
</div>
@endsection