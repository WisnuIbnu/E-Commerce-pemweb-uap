@extends('layouts.app')

@section('title', 'Pesanan Berhasil - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Success Message -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-500 bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-tumbloo-white mb-2">Pesanan Berhasil!</h1>
            <p class="text-tumbloo-gray">Terima kasih telah berbelanja di Tumbloo</p>
        </div>

        <!-- Order Details -->
        <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-tumbloo-white mb-4">Detail Pesanan</h2>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-tumbloo-gray">Kode Transaksi:</span>
                    <span class="text-tumbloo-white font-mono font-semibold">{{ $transaction->code }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-tumbloo-gray">Toko:</span>
                    <span class="text-tumbloo-white">{{ $transaction->store->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-tumbloo-gray">Total Pembayaran:</span>
                    <span class="text-tumbloo-accent font-bold text-lg">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-tumbloo-gray">Status Pembayaran:</span>
                    <span class="px-3 py-1 bg-yellow-500 bg-opacity-20 text-yellow-400 rounded-full text-xs font-semibold">
                        {{ ucfirst($transaction->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            @if(auth()->user()->role === 'customer')
                <a href="{{ route('transactions.index') }}" 
                   class="flex-1 px-6 py-3 bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold rounded-lg transition text-center">
                    Lihat Pesanan Saya
                </a>
            @endif
            
            <a href="{{ route('dashboard') }}" 
               class="flex-1 px-6 py-3 bg-tumbloo-dark hover:bg-tumbloo-darker text-tumbloo-white border border-tumbloo-accent rounded-lg transition font-medium text-center">
                Kembali ke Beranda
            </a>
        </div>

        <!-- Payment Instructions -->
        <div class="mt-8 bg-blue-500 bg-opacity-10 border border-blue-500 rounded-lg p-6">
            <h3 class="text-lg font-bold text-blue-400 mb-3">Instruksi Pembayaran</h3>
            <ol class="list-decimal list-inside space-y-2 text-sm text-tumbloo-gray">
                <li>Silakan lakukan pembayaran sesuai total yang tertera</li>
                <li>Detail pembayaran telah dikirim ke email Anda</li>
                <li>Konfirmasi pembayaran akan diproses dalam 1x24 jam</li>
                <li>Pesanan akan dikirim setelah pembayaran dikonfirmasi</li>
            </ol>
        </div>
    </div>
</div>
@endsection