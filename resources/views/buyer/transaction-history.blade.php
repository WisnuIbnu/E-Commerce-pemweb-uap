@extends('layouts.buyer')

@section('title', 'History - WALKUNO')

@section('content')

<section class="min-h-screen py-10 md:py-20">
    <div class="container-custom">
        <h1 class="font-heading font-black text-3xl mb-12 uppercase tracking-tighter">Order History</h1>

        @if($transactions && $transactions->count() > 0)
            <div class="bg-white border-t border-b border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="text-[10px] uppercase tracking-widest font-bold text-slate-400 border-b border-gray-100">
                                <th class="pb-4">Order ID</th>
                                <th class="pb-4">Date</th>
                                <th class="pb-4">Status</th>
                                <th class="pb-4">Items</th>
                                <th class="pb-4 text-right">Total</th>
                                <th class="pb-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($transactions as $transaction)
                                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                    <td class="py-6 font-bold text-black font-mono">#{{ $transaction->code }}</td>
                                    <td class="py-6 text-slate-500">{{ $transaction->created_at->format('M d, Y') }}</td>
                                    <td class="py-6">
                                        @php
                                            $color = match($transaction->status) {
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'paid', 'processing' => 'bg-blue-100 text-blue-800',
                                                'shipped', 'delivered' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-1 {{ $color }}">
                                            {{ $transaction->status }}
                                        </span>
                                    </td>
                                    <td class="py-6">
                                        <div class="flex items-center gap-4">
                                            @php $firstItem = $transaction->details->first(); @endphp
                                            @if($firstItem && $firstItem->product)
                                                <div class="h-12 w-12 bg-gray-100 rounded overflow-hidden flex-shrink-0 border border-gray-200">
                                                    @if($firstItem->product->images->first())
                                                        <img src="{{ Str::startsWith($firstItem->product->images->first()->image, 'http') ? $firstItem->product->images->first()->image : asset('storage/' . $firstItem->product->images->first()->image) }}" class="h-full w-full object-cover">
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-bold text-slate-900 text-sm line-clamp-1">{{ $firstItem->product->name }}</p>
                                                    <p class="text-xs text-slate-500">{{ $firstItem->qty }} item(s) 
                                                        @if($transaction->details->count() > 1)
                                                            <span class="text-slate-400">+ {{ $transaction->details->count() - 1 }} other products</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            @else
                                                <span class="text-sm text-slate-400">Items unavailable</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-6 text-right font-medium">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                    <td class="py-6 text-right">
                                        <a href="{{ route('transaction.detail', $transaction->id) }}" class="text-xs font-bold uppercase tracking-widest text-black underline underline-offset-4 hover:text-blue-600 transition-colors">
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-8">
                {{ $transactions->links() }}
            </div>

        @else
            <div class="border-t border-b border-gray-100 py-24 text-center">
                <p class="text-slate-400 mb-6 text-lg">No orders found.</p>
                <a href="{{ route('home') }}" class="inline-block px-8 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-slate-800 transition-colors">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
