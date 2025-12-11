@extends('layouts.app')

@section('title', 'Detail Transaksi - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 text-tumbloo-accent hover:text-tumbloo-accent-light mb-6 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Riwayat
        </a>

        <h1 class="text-3xl font-bold text-tumbloo-white mb-8">Detail Transaksi</h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-900/50 border border-green-500 rounded-lg text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <div class="text-sm text-tumbloo-gray mb-1">Kode Transaksi</div>
                    <div class="text-tumbloo-white font-semibold text-lg">{{ $transaction->code }}</div>
                </div>
                <div>
                    @php
                        $statusClasses = [
                            'pending' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500',
                            'paid' => 'bg-blue-500/20 text-blue-400 border-blue-500',
                            'processing' => 'bg-purple-500/20 text-purple-400 border-purple-500',
                            'shipped' => 'bg-indigo-500/20 text-indigo-400 border-indigo-500',
                            'delivered' => 'bg-green-500/20 text-green-400 border-green-500',
                            'cancelled' => 'bg-red-500/20 text-red-400 border-red-500',
                        ];
                        $statusLabels = [
                            'pending' => 'Menunggu Pembayaran',
                            'paid' => 'Sudah Dibayar',
                            'processing' => 'Diproses',
                            'shipped' => 'Dikirim',
                            'delivered' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ];
                    @endphp
                    <div class="text-sm text-tumbloo-gray mb-1">Status</div>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold border {{ $statusClasses[$transaction->payment_status] ?? '' }}">
                        {{ $statusLabels[$transaction->payment_status] ?? $transaction->payment_status }}
                    </span>
                </div>
                <div>
                    <div class="text-sm text-tumbloo-gray mb-1">Tanggal Pemesanan</div>
                    <div class="text-tumbloo-white">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</div>
                </div>
                <div>
                    <div class="text-sm text-tumbloo-gray mb-1">Toko</div>
                    <div class="text-tumbloo-white">{{ $transaction->store->name }}</div>
                </div>
            </div>

            @if($transaction->tracking_number)
                <div class="bg-tumbloo-dark rounded-lg p-4 border border-tumbloo-accent/30">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-tumbloo-gray mb-1">Nomor Resi</div>
                            <div class="text-tumbloo-white font-semibold">{{ $transaction->tracking_number }}</div>
                        </div>
                        <button onclick="copyTrackingNumber()" class="text-tumbloo-accent hover:text-tumbloo-accent-light transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6 mb-6">
            <h2 class="text-xl font-bold text-tumbloo-white mb-4">Alamat Pengiriman</h2>
            <div class="text-tumbloo-gray">
                <p class="mb-2">{{ $transaction->address }}</p>
                <p>{{ $transaction->city }}, {{ $transaction->postal_code }}</p>
            </div>
            <div class="mt-4 pt-4 border-t border-tumbloo-accent">
                <div class="flex items-center gap-2 text-tumbloo-gray">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span>{{ $transaction->shipping }} - {{ ucfirst($transaction->shipping_type) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6 mb-6">
            <h2 class="text-xl font-bold text-tumbloo-white mb-4">Produk yang Dibeli</h2>
            <div class="space-y-4">
                @foreach($transaction->details as $detail)
                    <div class="flex gap-4 pb-4 border-b border-tumbloo-accent last:border-0 last:pb-0">
                        <div class="w-24 h-24 rounded-lg overflow-hidden bg-tumbloo-dark flex-shrink-0">
                            @if($detail->product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $detail->product->images->first()->image) }}" 
                                     alt="{{ $detail->product->name }}"
                                     class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-tumbloo-white font-semibold mb-2">{{ $detail->product->name }}</h3>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-tumbloo-gray text-sm">{{ $detail->qty }}x Rp {{ number_format($detail->product->price, 0, ',', '.') }}</span>
                                <span class="text-tumbloo-accent font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                            </div>
                            
                            @if($transaction->payment_status === 'delivered')
                                <a href="{{ route('reviews.create', ['transaction' => $transaction->id, 'product' => $detail->product_id]) }}" 
                                   class="inline-flex items-center gap-1 text-sm text-tumbloo-accent hover:text-tumbloo-accent-light transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    Beri Ulasan
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6">
            <h2 class="text-xl font-bold text-tumbloo-white mb-4">Rincian Pembayaran</h2>
            <div class="space-y-3">
                <div class="flex justify-between text-tumbloo-gray">
                    <span>Subtotal Produk</span>
                    <span class="text-tumbloo-white">Rp {{ number_format($transaction->details->sum('subtotal'), 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-tumbloo-gray">
                    <span>Ongkos Kirim</span>
                    <span class="text-tumbloo-white">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-tumbloo-gray">
                    <span>Pajak (11%)</span>
                    <span class="text-tumbloo-white">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-tumbloo-accent pt-3">
                    <div class="flex justify-between text-xl font-bold">
                        <span class="text-tumbloo-white">Total Pembayaran</span>
                        <span class="text-tumbloo-accent">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($transaction->payment_status === 'pending')
            <div class="mt-6 flex gap-4">
                <form action="{{ route('transactions.cancel', $transaction->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            onclick="return confirm('Yakin ingin membatalkan pesanan ini?')"
                            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition">
                        Batalkan Pesanan
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

<script>
function copyTrackingNumber() {
    const trackingNumber = '{{ $transaction->tracking_number }}';
    navigator.clipboard.writeText(trackingNumber).then(() => {
        alert('Nomor resi berhasil disalin!');
    });
}
</script>
@endsection