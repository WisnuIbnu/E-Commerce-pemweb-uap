@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-8">
    <div class="container-custom">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Kelola Pesanan</h1>
            <p class="text-tumbloo-gray">Lihat dan update pesanan masuk</p>
        </div>

        <!-- Filter -->
        <div class="card p-6 mb-6">
            <form action="{{ route('store.orders.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="label">Filter Status</label>
                    <select name="status" class="select-field">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary">
                    Filter
                </button>
                <a href="{{ route('store.orders.index') }}" class="btn-secondary">
                    Reset
                </a>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="card p-6">
            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Pembeli</th>
                                <th>Total Item</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td class="font-semibold">#{{ $order->id }}</td>
                                <td>
                                    <div>
                                        <p class="font-semibold">{{ $order->buyer->name }}</p>
                                        <p class="text-xs text-tumbloo-gray">{{ $order->buyer->email }}</p>
                                    </div>
                                </td>
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
                                <td>
                                    <a href="{{ route('store.orders.show', $order->id) }}" 
                                        class="text-tumbloo-black hover:text-tumbloo-accent font-semibold text-sm">
                                        Detail →
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $orders->links() }}
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