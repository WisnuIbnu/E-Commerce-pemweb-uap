@extends('admin.layouts.layout')

@section('title', 'Kelola Transaksi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-tumbloo-black">Kelola Transaksi</h1>
        <p class="text-tumbloo-gray mt-1">Monitor semua transaksi yang terjadi di platform</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-tumbloo-gray">Total Transaksi</p>
                    <p class="text-2xl font-bold text-tumbloo-black mt-1">{{ $transactions->total() }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-3 rounded-lg">
                    <svg class="h-6 w-6 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-tumbloo-gray">Pending</p>
                    <p class="text-2xl font-bold text-tumbloo-black mt-1">
                        {{ $transactions->where('payment_status', 'pending')->count() }}
                    </p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-tumbloo-gray">Processing</p>
                    <p class="text-2xl font-bold text-tumbloo-black mt-1">
                        {{ $transactions->where('payment_status', 'processing')->count() }}
                    </p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-tumbloo-gray">Selesai</p>
                    <p class="text-2xl font-bold text-tumbloo-black mt-1">
                        {{ $transactions->where('payment_status', 'delivered')->count() }}
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    @if($transactions->count() > 0)
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Pembeli</th>
                        <th>Toko</th>
                        <th>Total</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>
                            <p class="font-semibold text-tumbloo-black">{{ $transaction->invoice }}</p>
                            <p class="text-sm text-tumbloo-gray">{{ $transaction->details->count() }} item</p>
                        </td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <div class="h-8 w-8 rounded-full bg-tumbloo-black flex items-center justify-center text-tumbloo-white text-sm font-semibold">
                                    {{ substr($transaction->buyer->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-tumbloo-black">{{ $transaction->buyer->name }}</p>
                                    <p class="text-sm text-tumbloo-gray">{{ $transaction->buyer->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="font-medium text-tumbloo-black">{{ $transaction->store->name }}</p>
                        </td>
                        <td>
                            <p class="font-bold text-tumbloo-black">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</p>
                            <p class="text-sm text-tumbloo-gray">
                                Subtotal: Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}<br>
                                Ongkir: Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}
                            </p>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ strtoupper($transaction->payment_method) }}</span>
                        </td>
                        <td>
                            @if($transaction->payment_status == 'delivered')
                            <span class="badge badge-success">Selesai</span>
                            @elseif($transaction->payment_status == 'shipped')
                            <span class="badge" style="background: #3b82f6; color: white;">Dikirim</span>
                            @elseif($transaction->payment_status == 'processing')
                            <span class="badge badge-warning">Diproses</span>
                            @elseif($transaction->payment_status == 'pending')
                            <span class="badge" style="background: #f59e0b; color: white;">Pending</span>
                            @elseif($transaction->payment_status == 'cancelled')
                            <span class="badge badge-danger">Dibatalkan</span>
                            @else
                            <span class="badge badge-info">{{ ucfirst($transaction->payment_status) }}</span>
                            @endif
                        </td>
                        <td class="text-sm text-tumbloo-gray">
                            {{ $transaction->created_at->format('d M Y') }}<br>
                            <span class="text-xs">{{ $transaction->created_at->format('H:i') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="card p-12 text-center">
        <div class="flex justify-center mb-4">
            <div class="bg-tumbloo-offwhite p-6 rounded-full">
                <svg class="h-16 w-16 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-bold text-tumbloo-black mb-2">Belum Ada Transaksi</h3>
        <p class="text-tumbloo-gray">Transaksi akan muncul di sini setelah ada pembelian</p>
    </div>
    @endif

    <!-- Transaction Details Section -->
    @if($transactions->count() > 0)
    <div class="card p-6">
        <h2 class="text-xl font-bold text-tumbloo-black mb-4">Detail Produk Transaksi Terbaru</h2>
        
        @foreach($transactions->take(5) as $transaction)
        <div class="mb-6 pb-6 border-b border-tumbloo-gray-light last:border-0">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-tumbloo-black">{{ $transaction->invoice }}</h3>
                <span class="text-sm text-tumbloo-gray">{{ $transaction->created_at->format('d M Y H:i') }}</span>
            </div>
            
            <div class="space-y-2">
                @foreach($transaction->details as $detail)
                <div class="flex items-center justify-between p-3 bg-tumbloo-offwhite rounded-lg">
                    <div class="flex items-center space-x-3 flex-1">
                        @if($detail->product && $detail->product->images->first())
                        <img src="{{ Storage::url($detail->product->images->first()->image) }}" 
                            alt="{{ $detail->product->name }}" 
                            class="h-12 w-12 rounded-lg object-cover">
                        @else
                        <div class="h-12 w-12 rounded-lg bg-tumbloo-gray-light flex items-center justify-center">
                            <svg class="h-6 w-6 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                        <div class="flex-1">
                            <p class="font-medium text-tumbloo-black">{{ $detail->product ? $detail->product->name : 'Produk Dihapus' }}</p>
                            <p class="text-sm text-tumbloo-gray">{{ $detail->qty }} x Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <p class="font-semibold text-tumbloo-black">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection