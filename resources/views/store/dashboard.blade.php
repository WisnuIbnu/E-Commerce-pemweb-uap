@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-8">
    <div class="container-custom">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Dashboard Toko</h1>
            <p class="text-tumbloo-gray">Kelola toko dan pesanan Anda</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-tumbloo-gray mb-1">Total Produk</p>
                        <p class="text-3xl font-bold text-tumbloo-black">{{ $stats['total_products'] }}</p>
                    </div>
                    <div class="bg-tumbloo-offwhite p-3 rounded-lg">
                        <svg class="w-8 h-8 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-tumbloo-gray mb-1">Pesanan Pending</p>
                        <p class="text-3xl font-bold text-tumbloo-black">{{ $stats['pending_orders'] }}</p>
                    </div>
                    <div class="bg-tumbloo-offwhite p-3 rounded-lg">
                        <svg class="w-8 h-8 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-tumbloo-gray mb-1">Total Revenue</p>
                        <p class="text-3xl font-bold text-tumbloo-black">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-tumbloo-offwhite p-3 rounded-lg">
                        <svg class="w-8 h-8 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-tumbloo-gray mb-1">Saldo</p>
                        <p class="text-3xl font-bold text-tumbloo-black">Rp {{ number_format($stats['balance'], 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-tumbloo-offwhite p-3 rounded-lg">
                        <svg class="w-8 h-8 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-tumbloo-black">Pesanan Terbaru</h2>
                <a href="{{ route('store.orders.index') }}" class="link-no-underline text-sm font-semibold">
                    Lihat Semua →
                </a>
            </div>

            @if($recentOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Pembeli</th>
                                <th>Produk</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td class="font-semibold">#{{ $order->id }}</td>
                                <td>{{ $order->buyer->name }}</td>
                                <td>{{ $order->details->count() }} item</td>
                                <td class="font-semibold">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($order->payment_status == 'delivered') badge-success
                                        @elseif($order->payment_status == 'pending') badge-warning
                                        @elseif($order->payment_status == 'cancelled') badge-danger
                                        @else badge-info
                                        @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-tumbloo-gray-light mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-tumbloo-gray">Belum ada pesanan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection