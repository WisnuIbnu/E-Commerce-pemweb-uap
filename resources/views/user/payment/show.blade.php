@extends('layouts.app')

@section('title', 'Detail Pembayaran - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-500 bg-opacity-10 border-l-4 border-green-500 text-green-400 px-6 py-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 bg-opacity-10 border-l-4 border-red-500 text-red-400 px-6 py-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Header -->
        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-tumbloo-white mb-1">Detail Pembayaran</h1>
                    <p class="text-tumbloo-gray">Kode Transaksi: <span class="text-blue-200 font-semibold">{{ $transaction->code }}</span></p>
                </div>
                <div class="text-right">
                    <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold
                        @if($transaction->payment_status == 'pending') bg-yellow-500/20 text-yellow-400
                        @elseif($transaction->payment_status == 'unpaid') bg-orange-500/20 text-orange-400
                        @elseif($transaction->payment_status == 'paid') bg-green-500/20 text-green-400
                        @elseif($transaction->payment_status == 'failed') bg-red-500/20 text-red-400
                        @elseif($transaction->payment_status == 'cancelled') bg-gray-500/20 text-gray-400
                        @else bg-gray-500/20 text-gray-400
                        @endif">
                        @if($transaction->payment_status == 'pending') Menunggu Pembayaran
                        @elseif($transaction->payment_status == 'unpaid') Belum Dibayar
                        @elseif($transaction->payment_status == 'paid') Sudah Dibayar
                        @elseif($transaction->payment_status == 'failed') Pembayaran Gagal
                        @elseif($transaction->payment_status == 'cancelled') Dibatalkan
                        @else {{ ucfirst($transaction->payment_status) }}
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-tumbloo-gray">Tanggal Pemesanan</p>
                    <p class="text-tumbloo-white font-semibold">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-tumbloo-gray">Batas Pembayaran</p>
                    <p class="text-red-400 font-semibold">{{ $transaction->created_at->addHours(24)->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Instructions -->
        @if($transaction->payment_status == 'pending' || $transaction->payment_status == 'unpaid')
        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6 mb-6">
            <h2 class="text-xl font-bold text-tumbloo-white mb-4">Instruksi Pembayaran</h2>
            
            <div class="bg-tumbloo-dark rounded-lg p-4 mb-4">
                <h3 class="text-tumbloo-white font-semibold mb-3">Transfer Bank</h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center py-2 border-b border-tumbloo-accent/30">
                        <span class="text-tumbloo-gray">Bank</span>
                        <span class="text-tumbloo-offwhite font-semibold">Bank BCA</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-tumbloo-accent/30">
                        <span class="text-tumbloo-gray">Nomor Rekening</span>
                        <div class="text-right">
                            <span class="text-tumbloo-offwhite font-mono font-semibold">1234567890</span>
                            <button onclick="copyToClipboard('1234567890')" class="ml-2 text-blue-100 hover:text-blue-400">
                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-tumbloo-accent/30">
                        <span class="text-tumbloo-gray">Atas Nama</span>
                        <span class="text-tumbloo-offwhite font-semibold">PT Tumbloo Indonesia</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-tumbloo-gray text-lg">Jumlah Transfer</span>
                        <div class="text-right">
                            <span class="text-blue-500 font-bold text-xl">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                            <button onclick="copyToClipboard('{{ $transaction->grand_total }}')" class="ml-2 text-blue-100 hover:text-blue-400">
                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4 mb-4">
                <div class="flex gap-3">
                    <svg class="w-6 h-6 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <p class="text-yellow-400 font-semibold mb-1">Penting!</p>
                        <ul class="text-sm text-tumbloo-gray space-y-1">
                            <li>• Transfer sesuai dengan jumlah yang tertera</li>
                            <li>• Setelah transfer, klik tombol "Saya Sudah Membayar"</li>
                            <li>• Pembayaran akan diverifikasi dalam 1x24 jam</li>
                        </ul>
                    </div>
                </div>
            </div>

            <button onclick="confirmPayment()" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-4 rounded-lg transition">
                ✓ Saya Sudah Membayar
            </button>
        </div>
        @endif

        @if($transaction->payment_status == 'paid')
        <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-6 mb-6">
            <div class="flex gap-4 items-center">
                <svg class="w-12 h-12 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-green-400 font-bold text-xl mb-1">Pembayaran Berhasil!</h3>
                    <p class="text-tumbloo-gray">Pesanan Anda sedang diproses oleh seller. Anda akan menerima nomor resi pengiriman segera.</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Order Details -->
        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6 mb-6">
            <h2 class="text-xl font-bold text-tumbloo-white mb-4">Detail Pesanan</h2>
            
            <div class="space-y-4">
                @foreach($transaction->transactionDetails as $detail)
                    <div class="flex gap-4 pb-4 border-b border-tumbloo-accent last:border-0 last:pb-0">
                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-tumbloo-dark flex-shrink-0">
                            @if($detail->product->images->isNotEmpty())
                                <img src="{{ asset($detail->product->images->first()->image) }}" 
                                     alt="{{ $detail->product->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-tumbloo-white font-semibold mb-1">{{ $detail->product->name }}</h3>
                            <p class="text-sm text-tumbloo-gray mb-2">{{ $transaction->store->name }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-200 text-sm">{{ $detail->qty }}x Rp {{ number_format($detail->subtotal / $detail->qty, 0, ',', '.') }}</span>
                                <span class="text-blue-500 font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Shipping Info -->
        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6 mb-6">
            <h2 class="text-xl font-bold text-tumbloo-white mb-4">Alamat Pengiriman</h2>
            <div class="text-tumbloo-gray space-y-1">
                <p class="text-tumbloo-white font-semibold">{{ $transaction->buyer->name }}</p>
                <p>{{ $transaction->address }}</p>
                <p>{{ $transaction->city }}, {{ $transaction->postal_code }}</p>
                <p class="text-tumbloo-accent mt-2">{{ strtoupper($transaction->shipping) }} - {{ ucfirst($transaction->shipping_type) }}</p>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6">
            <h2 class="text-xl font-bold text-tumbloo-white mb-4">Ringkasan Pembayaran</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between text-tumbloo-gray">
                    <span>Subtotal Produk</span>
                    <span class="text-blue-300">Rp {{ number_format($transaction->grand_total - $transaction->shipping_cost - $transaction->tax, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-tumbloo-gray">
                    <span>Ongkir</span>
                    <span class="text-blue-300">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-tumbloo-gray">
                    <span>Pajak (11%)</span>
                    <span class="text-blue-300">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-tumbloo-accent pt-3">
                    <div class="flex justify-between text-lg font-bold">
                        <span class="text-tumbloo-white">Total Pembayaran</span>
                        <span class="text-blue-400">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex gap-4">
            <a href="{{ route('transaction.index') }}" 
               class="flex-1 text-center bg-gray-500 hover:bg-gray-600 text-tumbloo-white font-semibold py-3 px-4 rounded-lg border border-tumbloo-accent transition">
                Lihat Semua Transaksi
            </a>
            <a href="{{ route('dashboard') }}" 
               class="flex-1 text-center bg-green-400 hover:bg-green-500 text-white font-semibold py-3 px-4 rounded-lg transition">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Berhasil disalin!');
    });
}

function confirmPayment() {
    if (confirm('Apakah Anda yakin sudah melakukan pembayaran?')) {
        fetch('{{ route("payment.confirm", $transaction->code) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }
}
</script>
@endsection