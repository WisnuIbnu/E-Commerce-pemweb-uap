@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('seller.orders.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">&larr; Back to Orders</a>
        <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
        <p class="text-gray-600">Order #{{ $transaction->code }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Order Info -->
        <div class="md:col-span-2 space-y-6">
            <!-- Items -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Order Items</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($transaction->details as $detail)
                        <div class="p-6 flex items-center">
                            <div class="flex-shrink-0 w-16 h-16 border rounded-md overflow-hidden bg-gray-100">
                                @if($detail->product->productImages->first())
                                    <img src="{{ Storage::url($detail->product->productImages->first()->image_path) }}" alt="{{ $detail->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-sm font-medium text-gray-900">{{ $detail->product->name }}</h3>
                                <p class="text-sm text-gray-500">Qty: {{ $detail->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Transaction Info -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment & Shipping</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $transaction->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Payment Method</p>
                        <p class="text-sm font-medium text-gray-900">Virtual Account</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Shipping Service</p>
                        <p class="text-sm font-medium text-gray-900">{{ $transaction->shipping_service }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Tracking Number</p>
                        <p class="text-sm font-medium text-gray-900">{{ $transaction->tracking_number ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Customer Info -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer</h2>
                <div class="flex items-center mb-4">
                     <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                        @if($transaction->buyer && $transaction->buyer->profile_picture)
                            <img src="{{ Storage::url($transaction->buyer->profile_picture) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ $transaction->buyer->user->name ?? 'Unknown User' }}</p>
                        <p class="text-xs text-gray-500">{{ $transaction->buyer->user->email ?? '' }}</p>
                    </div>
                </div>
                <div class="border-t pt-4">
                    <p class="text-sm font-medium text-gray-900 mb-1">Shipping Address</p>
                    <p class="text-sm text-gray-500">{{ $transaction->shipping_address }}</p>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Summary</h2>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Shipping</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    @if($transaction->admin_fee > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Admin Fee</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($transaction->admin_fee, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="pt-2 border-t flex justify-between items-center">
                        <span class="text-base font-bold text-gray-900">Total</span>
                        <span class="text-base font-bold text-blue-600">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
