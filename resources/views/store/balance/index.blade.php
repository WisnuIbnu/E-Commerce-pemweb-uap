@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-8">
    <div class="container-custom">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Saldo Toko</h1>
            <p class="text-tumbloo-gray">Kelola saldo dan riwayat pendapatan Anda</p>
        </div>

        <!-- Balance Card -->
        <div class="card-dark p-8 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-tumbloo-gray-light mb-2">Saldo Tersedia</p>
                    <p class="text-4xl font-bold text-tumbloo-white mb-4">
                        Rp {{ number_format($balance->balance ?? 0, 0, ',', '.') }}
                    </p>
                    <a href="{{ route('store.withdrawal.index') }}" class="btn-primary btn-sm">
                        Tarik Saldo
                    </a>
                </div>
                <div class="hidden md:block">
                    <svg class="w-24 h-24 text-tumbloo-white opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="card p-6">
            <h2 class="text-xl font-bold text-tumbloo-black mb-6">Riwayat Transaksi</h2>

            @if($history->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Pembeli</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history as $transaction)
                            <tr>
                                <td class="font-semibold">#{{ $transaction->id }}</td>
                                <td>{{ $transaction->buyer->name }}</td>
                                <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                                <td class="font-semibold text-green-600">
                                    + Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        {{ ucfirst($transaction->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $history->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-tumbloo-gray-light mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-tumbloo-gray">Belum ada riwayat transaksi</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection