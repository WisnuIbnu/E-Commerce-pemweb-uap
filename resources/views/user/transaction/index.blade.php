@extends('layouts.app')

@section('title', 'Riwayat Transaksi - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-tumbloo-white mb-8">Riwayat Transaksi</h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-900/50 border border-green-500 rounded-lg text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if($transactions->isEmpty())
            <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-tumbloo-gray mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-tumbloo-white mb-2">Belum Ada Transaksi</h2>
                <p class="text-tumbloo-gray mb-6">Anda belum memiliki riwayat transaksi</p>
                <a href="{{ route('home') }}" class="inline-block bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold py-3 px-6 rounded-lg transition">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($transactions as $transaction)
                    <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent overflow-hidden">
                        <!-- Transaction Header -->
                        <div class="bg-tumbloo-dark px-6 py-4 border-b border-tumbloo-accent">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div>
                                        <div class="text-sm text-tumbloo-gray">Kode Transaksi</div>
                                        <div class="text-tumbloo-white font-semibold">{{ $transaction->code }}</div>
                                    </div>
                                    <div class="h-8 w-px bg-tumbloo-accent"></div>
                                    <div>
                                        <div class="text-sm text-tumbloo-gray">Tanggal</div>
                                        <div class="text-tumbloo-white">{{ $transaction->created_at->format('d M Y') }}</div>
                                    </div>
                                    <div class="h-8 w-px bg-tumbloo-accent"></div>
                                    <div>
                                        <div class="text-sm text-tumbloo-gray">Toko</div>
                                        <div class="text-tumbloo-white">{{ $transaction->store->name }}</div>
                                    </div>
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
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold border {{ $statusClasses[$transaction->payment_status] ?? '' }}">
                                        {{ $statusLabels[$transaction->payment_status] ?? $transaction->payment_status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Body -->
                        <div class="p-6">
                            <!-- Products -->
                            <div class="space-y-4 mb-4">
                                @foreach($transaction->transactionDetails as $detail)
                                    <div class="flex gap-4">
                                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-tumbloo-dark flex-shrink-0">
                                            @if($detail->product->images->isNotEmpty())
                                                <img src="{{ asset(ltrim($detail->product->images->first()->image, '/')) }}"
                                                alt="{{ $detail->product->name }}"
                                                class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-tumbloo-white font-semibold mb-1">{{ $detail->product->name }}</h3>
                                            <div class="flex justify-between items-center">
                                                <span class="text-blue-200 text-sm">{{ $detail->qty }}x Rp {{ number_format($detail->product->price, 0, ',', '.') }}</span>
                                                <span class="text-blue-500 font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Total -->
                            <div class="border-t border-tumbloo-accent pt-4 mb-4">
                                <div class="flex justify-between text-lg font-bold">
                                    <span class="text-tumbloo-white">Total Pembayaran</span>
                                    <span class="text-blue-500">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3">
                                <a href="{{ route('payment.show', $transaction->id) }}" 
                                   class="flex-1 text-center bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold py-2 px-4 rounded-lg transition">
                                    Lihat Detail
                                </a>
                                
                                @if($transaction->payment_status === 'pending')
                                    <form action="{{ route('transaction.cancel', $transaction->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                onclick="return confirm('Yakin ingin membatalkan pesanan ini?')"
                                                class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                                            Batalkan Pesanan
                                        </button>
                                    </form>
                                @endif

                                @if($transaction->payment_status === 'delivered')
                                    <a href="{{ route('reviews.create', ['transaction' => $transaction->id, 'product' => $transaction->transactionDetails->first()->product_id]) }}" 
                                       class="flex-1 text-center bg-tumbloo-dark hover:bg-tumbloo-accent/20 text-tumbloo-white border border-tumbloo-accent font-semibold py-2 px-4 rounded-lg transition">
                                        Beri Ulasan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection