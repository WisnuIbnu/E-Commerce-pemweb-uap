@extends('layouts.app')
@section('content')
<div class="bg-tumbloo-dark min-h-screen">
    <div class="container-custom">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Kelola Pesanan</h1>
            <p class="text-gray-400">Lihat dan update pesanan masuk</p>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 mb-6 border border-zinc-800">
            <form action="{{ route('store.orders.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="text-sm font-medium text-gray-300 block mb-2">Filter Status</label>
                    <select name="status" class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white focus:outline-none focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    Filter
                </button>
                <a href="{{ route('store.orders.index') }}" class="px-6 py-2 bg-zinc-800 hover:bg-zinc-700 text-white rounded-lg font-medium transition-colors">
                    Reset
                </a>
            </form>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-zinc-800">
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Order ID</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Pembeli</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Total Item</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Total Harga</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Status</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Tanggal</th>
                                <th class="text-left py-4 px-4 text-sm font-medium text-gray-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition-colors">
                                <td class="py-4 px-4 font-semibold text-white">#{{ $order->id }}</td>
                                <td class="py-4 px-4">
                                    <div>
                                        <p class="font-semibold text-white">{{ $order->buyer->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $order->buyer->email }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-gray-300">{{ $order->transactionDetails->count() }} item</td>
                                <td class="py-4 px-4 font-semibold text-white">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        @if($order->payment_status == 'delivered') bg-green-500/10 text-green-400 border border-green-500/20
                                        @elseif($order->payment_status == 'pending') bg-yellow-500/10 text-yellow-400 border border-yellow-500/20
                                        @elseif($order->payment_status == 'cancelled') bg-red-500/10 text-red-400 border border-red-500/20
                                        @else bg-blue-500/10 text-blue-400 border border-blue-500/20
                                        @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="py-4 px-4">
                                    <a href="{{ route('store.orders.show', $order->id) }}" 
                                        class="text-blue-400 hover:text-blue-300 font-semibold text-sm transition-colors">
                                        Detail →
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $orders->links() }}</div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-400">Belum ada pesanan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection