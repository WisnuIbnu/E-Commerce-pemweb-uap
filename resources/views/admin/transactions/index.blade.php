@extends('admin.layouts.layout')

@section('title', 'Kelola Transaksi')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-white">Kelola Transaksi</h1>
        <p class="text-gray-400 mt-1">Monitor semua transaksi yang terjadi di platform</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Total Transaksi</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $transactions->total() }}</p>
                </div>
                <div class="bg-cyan-500/10 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Pending</p>
                    <p class="text-2xl font-bold text-white mt-1">
                        {{ $transactions->where('payment_status', 'pending')->count() }}
                    </p>
                </div>
                <div class="bg-yellow-500/10 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Processing</p>
                    <p class="text-2xl font-bold text-white mt-1">
                        {{ $transactions->where('payment_status', 'processing')->count() }}
                    </p>
                </div>
                <div class="bg-blue-500/10 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Selesai</p>
                    <p class="text-2xl font-bold text-white mt-1">
                        {{ $transactions->where('payment_status', 'delivered')->count() }}
                    </p>
                </div>
                <div class="bg-green-500/10 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    @if($transactions->count() > 0)
    <div class="bg-zinc-900 rounded-xl border border-zinc-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-zinc-800">
                        <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Invoice</th>
                        <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Pembeli</th>
                        <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Toko</th>
                        <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Total</th>
                        <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Metode Bayar</th>
                        <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Status</th>
                        <th class="text-left py-4 px-6 text-sm font-medium text-gray-400">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition-colors">
                        <td class="py-4 px-6">
                            <p class="font-semibold text-white">{{ $transaction->code }}</p>
                            <p class="text-sm text-gray-400">{{ $transaction->transactionDetails->count() }} item</p>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-2">
                                <div class="h-8 w-8 rounded-full bg-tumbloo-gray flex items-center justify-center text-white text-sm font-semibold">
                                    {{ substr($transaction->buyer->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-white">{{ $transaction->buyer->name }}</p>
                                    <p class="text-sm text-gray-400">{{ $transaction->buyer->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-medium text-white">{{ $transaction->store->name }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <p class="font-bold text-white">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-400">Ongkir: Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">{{ strtoupper($transaction->shipping) }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @if($transaction->payment_status == 'delivered')
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-500/10 text-green-400 border border-green-500/20">Selesai</span>
                            @elseif($transaction->payment_status == 'shipped')
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">Dikirim</span>
                            @elseif($transaction->payment_status == 'processing')
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Diproses</span>
                            @elseif($transaction->payment_status == 'pending')
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">Pending</span>
                            @elseif($transaction->payment_status == 'cancelled')
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-500/10 text-red-400 border border-red-500/20">Dibatalkan</span>
                            @else
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-cyan-500/10 text-cyan-400 border border-cyan-500/20">{{ ucfirst($transaction->payment_status) }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-400">
                            {{ $transaction->created_at->format('d M Y') }}<br>
                            <span class="text-xs">{{ $transaction->created_at->format('H:i') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
    @else
    <div class="bg-zinc-900 rounded-xl p-12 text-center border border-zinc-800">
        <div class="flex justify-center mb-4">
            <div class="bg-zinc-800 p-6 rounded-full">
                <svg class="h-16 w-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Belum Ada Transaksi</h3>
        <p class="text-gray-400">Transaksi akan muncul di sini setelah ada pembelian</p>
    </div>
    @endif

    @if($transactions->count() > 0)
    <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
        <h2 class="text-xl font-bold text-white mb-4">Detail Produk Transaksi Terbaru</h2>
        
        @foreach($transactions->take(5) as $transaction)
        <div class="mb-6 pb-6 border-b border-zinc-800 last:border-0">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-white">{{ $transaction->code }}</h3>
                <span class="text-sm text-gray-400">{{ $transaction->created_at->format('d M Y H:i') }}</span>
            </div>
            
            <div class="space-y-2">
                @foreach($transaction->transactionDetails as $detail)
                <div class="flex items-center justify-between p-3 bg-zinc-800/50 rounded-lg border border-zinc-700/50">
                    <div class="flex items-center space-x-3 flex-1">
                        @if($detail->product && $detail->product->images->first())
                        <img src="{{ asset($detail->product->images->first()->image) }}" 
                            alt="{{ $detail->product->name }}" 
                            class="h-12 w-12 rounded-lg object-cover">
                        @else
                        <div class="h-12 w-12 rounded-lg bg-zinc-700 flex items-center justify-center">
                            <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                        <div class="flex-1">
                            <p class="font-medium text-white">{{ $detail->product ? $detail->product->name : 'Produk Dihapus' }}</p>
                            <p class="text-sm text-gray-400">{{ $detail->qty }} item</p>
                        </div>
                    </div>
                    <p class="font-semibold text-white">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection