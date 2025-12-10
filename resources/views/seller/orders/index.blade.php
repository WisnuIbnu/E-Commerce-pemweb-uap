@extends('layouts.seller')

@section('title', 'Manajemen Pesanan')
@section('subtitle', 'Daftar pesanan masuk untuk toko ' . Auth::user()->store->name)

@section('seller-content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800">Pesanan Masuk</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-4 rounded-tl-xl">ID Transaksi</th>
                    <th class="p-4">Pembeli</th>
                    <th class="p-4">Total Belanja</th>
                    <th class="p-4">Status Bayar</th>
                    <th class="p-4">Resi</th>
                    <th class="p-4 rounded-tr-xl text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-700">
                @forelse($orders as $order)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                    <td class="p-4">
                        <span class="font-bold text-slate-900">#{{ $order->code }}</span>
                        <div class="text-xs text-slate-500">{{ $order->created_at->format('d M Y') }}</div>
                    </td>
                    <td class="p-4">
                        <div class="font-bold">{{ $order->buyer->user->name ?? 'Guest' }}</div>
                        <div class="text-xs text-slate-500">{{ $order->city }}</div>
                    </td>
                    <td class="p-4 font-bold text-indigo-600">
                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                    </td>
                    <td class="p-4">
                        @if($order->payment_status == 'paid')
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-600 rounded-full text-xs font-bold">Lunas</span>
                        @else
                            <span class="px-2 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-bold">Belum Dibayar</span>
                        @endif
                    </td>
                    <td class="p-4">
                        @if($order->tracking_number)
                            <span class="font-mono text-xs font-bold text-slate-700">{{ $order->tracking_number }}</span>
                        @else
                            <span class="text-xs italic text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <a href="{{ route('seller.orders.show', $order->id) }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 text-xs font-bold rounded-full hover:bg-slate-50 hover:text-primary transition-all shadow-sm">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                <i class="fa-solid fa-clipboard text-2xl text-slate-300"></i>
                            </div>
                            <p class="font-medium">Belum ada pesanan masuk.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $orders->links() }}
    </div>

</div>
@endsection