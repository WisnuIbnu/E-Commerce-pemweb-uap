@extends('layouts.app')
@section('content')
<div class="bg-tumbloo-dark min-h-screen">
    <div class="container-custom">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Saldo Toko</h1>
            <p class="text-gray-400">Kelola saldo dan riwayat pendapatan Anda</p>
        </div>

        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-8 mb-8 border border-blue-500/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 mb-2">Saldo Tersedia</p>
                    <p class="text-4xl font-bold text-white mb-4">
                        Rp {{ number_format($balance->balance ?? 0, 0, ',', '.') }}
                    </p>
                    <a href="{{ route('store.withdrawal.index') }}"
                        class="px-6 py-2 bg-white hover:bg-gray-100 text-blue-600 rounded-lg font-medium transition-colors inline-block">
                        Tarik Saldo
                    </a>
                </div>
                <div class="hidden md:block">
                    <svg class="w-24 h-24 text-white opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <h2 class="text-xl font-bold text-white mb-6">Riwayat Transaksi</h2>
            @if($history->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-zinc-800">
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Order ID</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Pembeli</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Tanggal</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Jumlah</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history as $transaction)
                                <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition-colors">
                                    <td class="py-4 px-4 font-semibold text-white">#{{ $transaction->id }}</td>
                                    <td class="py-4 px-4 text-gray-300">{{ $transaction->buyer->name }}</td>
                                    <td class="py-4 px-4 text-sm text-gray-400">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                                    <td class="py-4 px-4 font-semibold text-blue-400">
                                        + Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-500/10 text-green-400 border border-green-500/20">
                                            {{ ucfirst($transaction->payment_status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $history->links() }}</div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-400">Belum ada riwayat transaksi</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection