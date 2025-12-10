@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-8">
    <div class="container-custom">
        <div class="mb-8">
            <a href="{{ route('store.orders.index') }}" class="text-tumbloo-gray hover:text-tumbloo-black mb-4 inline-block">
                ← Kembali ke Pesanan
            </a>
            <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Detail Pesanan #{{ $order->code ?? $order->id }}</h1>
            <p class="text-tumbloo-gray">{{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success fade-in mb-6">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-6">
                    <h2 class="text-xl font-bold text-tumbloo-black mb-6">Produk</h2>
                    <div class="space-y-4">
                        @forelse($order->transactionDetails as $detail)
                        <div class="flex gap-4 pb-4 border-b border-tumbloo-gray-light last:border-0">
                            @if($detail->product && $detail->product->images && $detail->product->images->first())
                                <img src="{{ asset('storage/' . $detail->product->images->first()->image) }}" 
                                    alt="{{ $detail->product->name }}"
                                    class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-20 bg-tumbloo-gray-light rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-semibold text-tumbloo-black">{{ $detail->product->name ?? 'Produk Tidak Ditemukan' }}</h3>
                                <p class="text-sm text-tumbloo-gray mt-1">{{ $detail->qty }} x Rp {{ number_format($detail->subtotal / $detail->qty, 0, ',', '.') }}</p>
                                <p class="text-sm font-semibold text-tumbloo-black mt-2">
                                    Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <p class="text-tumbloo-gray text-center py-4">Tidak ada produk dalam pesanan ini.</p>
                        @endforelse
                    </div>
                </div>

                <div class="card p-6">
                    <h2 class="text-xl font-bold text-tumbloo-black mb-6">Informasi Pengiriman</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-tumbloo-gray">Alamat:</span>
                            <span class="font-semibold text-tumbloo-black text-right max-w-xs">{{ $order->address ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-tumbloo-gray">Kota:</span>
                            <span class="font-semibold text-tumbloo-black">{{ $order->city ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-tumbloo-gray">Kode Pos:</span>
                            <span class="font-semibold text-tumbloo-black">{{ $order->postal_code ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-tumbloo-gray">Jenis Pengiriman:</span>
                            <span class="font-semibold text-tumbloo-black">{{ $order->shipping_type ?? '-' }}</span>
                        </div>
                        @if($order->tracking_number)
                        <div class="flex justify-between">
                            <span class="text-tumbloo-gray">Tracking Number:</span>
                            <span class="font-mono font-semibold text-tumbloo-black">{{ $order->tracking_number }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card p-6">
                    <h3 class="font-bold text-tumbloo-black mb-4">Pembeli</h3>
                    <div class="space-y-2 text-sm">
                        <p class="font-semibold text-tumbloo-black">{{ $order->buyer->name ?? 'Nama Tidak Tersedia' }}</p>
                        <p class="text-tumbloo-gray">{{ $order->buyer->email ?? '-' }}</p>
                    </div>
                </div>

                <div class="card p-6">
                    <h3 class="font-bold text-tumbloo-black mb-4">Ringkasan</h3>
                    <div class="space-y-3 text-sm mb-4">
                        <div class="flex justify-between">
                            <span class="text-tumbloo-gray">Subtotal:</span>
                            <span class="font-semibold">Rp {{ number_format($order->transactionDetails->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-tumbloo-gray">Ongkir:</span>
                            <span class="font-semibold">Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</span>
                        </div>
                        @if($order->tax)
                        <div class="flex justify-between">
                            <span class="text-tumbloo-gray">Pajak:</span>
                            <span class="font-semibold">Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="divider"></div>
                        <div class="flex justify-between text-base">
                            <span class="font-bold text-tumbloo-black">Total:</span>
                            <span class="font-bold text-tumbloo-black">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="badge 
                            @if($order->payment_status == 'delivered') badge-success
                            @elseif($order->payment_status == 'pending') badge-warning
                            @elseif($order->payment_status == 'cancelled') badge-danger
                            @else badge-info
                            @endif w-full justify-center">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>

                @if($order->payment_status != 'delivered' && $order->payment_status != 'cancelled')
                <div class="card p-6">
                    <h3 class="font-bold text-tumbloo-black mb-4">Update Status</h3>
                    <form action="{{ route('store.orders.update-status', $order->id) }}" method="POST" class="mb-4">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="select-field mb-3">
                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->payment_status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->payment_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->payment_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->payment_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn-primary w-full btn-sm">Update Status</button>
                    </form>
                </div>

                @if(!$order->tracking_number && in_array($order->payment_status, ['processing', 'pending']))
                <div class="card p-6">
                    <h3 class="font-bold text-tumbloo-black mb-4">Tambah Tracking</h3>
                    <form action="{{ route('store.orders.update-tracking', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="tracking_number" 
                            class="input-field mb-3" 
                            placeholder="Nomor Resi" required>
                        <button type="submit" class="btn-primary w-full btn-sm">
                            Kirim Resi
                        </button>
                    </form>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection