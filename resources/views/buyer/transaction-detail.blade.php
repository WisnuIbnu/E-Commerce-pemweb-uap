@extends('layouts.buyer')

@section('title', 'Order Details - WalkUno')

@section('content')

<div class="bg-gray-50 py-12 min-h-screen">
    <div class="container-custom">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('transaction.history') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h1 class="text-3xl font-black text-gray-900">Order Details</h1>
            </div>

            <!-- Invoice Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header Status -->
                <div class="bg-blue-600 p-8 text-white flex justify-between items-center">
                    <div>
                        <p class="opacity-80 font-medium mb-1">Order ID</p>
                        <h2 class="text-2xl font-bold tracking-tight">{{ $transaction->code }}</h2>
                    </div>
                    <div class="text-right">
                        <p class="opacity-80 font-medium mb-1">Status</p>
                         @php
                            $statusColors = [
                                'pending' => 'bg-yellow-400 text-yellow-900',
                                'processing' => 'bg-blue-400 text-white',
                                'shipped' => 'bg-purple-400 text-white',
                                'delivered' => 'bg-green-400 text-white',
                                'cancelled' => 'bg-red-400 text-white',
                            ];
                            $statusClass = $statusColors[$transaction->payment_status] ?? 'bg-gray-200 text-gray-800';
                        @endphp
                        <span class="px-4 py-1.5 rounded-full font-bold uppercase tracking-wider text-sm {{ $statusClass }}">
                            {{ ucfirst($transaction->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="p-8 lg:p-12">
                     <!-- Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
                        <div>
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Shipping Information</h3>
                            <div class="space-y-1 text-gray-900 font-medium">
                                <p class="text-lg font-bold">{{ Auth::user()->name }}</p>
                                <p>{{ $transaction->address }}</p>
                                <p>{{ $transaction->city }}, {{ $transaction->postal_code }}</p>
                                <p class="mt-2 text-gray-500">{{ Auth::user()->phone }}</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Order Summary</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Order Date</span>
                                    <span class="font-bold text-gray-900">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Payment Method</span>
                                    <span class="font-bold text-gray-900">{{ $transaction->payment_method }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping Type</span>
                                    <span class="font-bold text-gray-900">{{ $transaction->shipping_type }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Delivery Status</span>
                                    @php
                                        $deliveryColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'shipped' => 'bg-purple-100 text-purple-800',
                                            'delivered' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $deliveryStatus = $transaction->delivery_status ?? 'pending';
                                        $colorClass = $deliveryColors[$deliveryStatus] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $colorClass }}">
                                        {{ ucfirst($deliveryStatus) }}
                                    </span>
                                </div>
                                @if($transaction->tracking_number)
                                <div class="flex justify-between pt-2 border-t border-gray-100">
                                    <span class="text-gray-600">Tracking No.</span>
                                    <span class="font-mono font-bold text-blue-600">{{ $transaction->tracking_number }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="border rounded-xl overflow-hidden mb-8">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider">
                                <tr>
                                    <th class="p-4 font-bold">Product</th>
                                    <th class="p-4 font-bold text-center">Qty</th>
                                    <th class="p-4 font-bold text-right">Price</th>
                                    <th class="p-4 font-bold text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                 @foreach($transaction->details as $detail)
                                    <tr>
                                        <td class="p-4">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                                    @if($detail->product && $detail->product->images->first())
                                                        <img src="{{ asset('storage/' . $detail->product->images->first()->image) }}" class="w-full h-full object-cover">
                                                    @endif
                                                </div>
                                                <span class="font-bold text-gray-900">{{ $detail->product->name ?? 'Product Deleted' }}</span>
                                            </div>
                                        </td>
                                        <td class="p-4 text-center font-medium text-gray-600">{{ $detail->qty }}</td>
                                        <td class="p-4 text-right font-medium text-gray-600">Rp {{ number_format($detail->subtotal / $detail->qty, 0, ',', '.') }}</td>
                                        <td class="p-4 text-right font-bold text-gray-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div class="flex justify-end">
                        <div class="w-full md:w-1/2 lg:w-1/3 space-y-3">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($transaction->grand_total - $transaction->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping Cost</span>
                                <span class="font-medium">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <span class="font-bold text-xl text-gray-900">Total Paid</span>
                                <span class="font-black text-2xl text-blue-600">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Confirm Payment Button for Pending --}}
                    @if($transaction->status === 'pending')
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="font-bold text-yellow-800 mb-1">Payment Pending</p>
                                        <p class="text-sm text-yellow-700">Please complete your payment to process this order. Click the button below after you have transferred the payment.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <form action="{{ route('payment.confirm', $transaction->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        style="background: #10b981 !important;" 
                                        class="w-full py-5 text-white text-center font-bold uppercase tracking-widest text-base hover:opacity-90 transition-all duration-300 rounded-lg shadow-2xl border-4 border-green-400">
                                    ✓ CONFIRM PAYMENT
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
