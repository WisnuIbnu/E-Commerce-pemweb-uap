@extends('layouts.buyer')

@section('title', 'Payment Confirmation - WALKUNO')

@section('content')

<section class="min-h-screen py-10 md:py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="container-custom max-w-4xl">
        
        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-8 bg-green-50 border-l-4 border-green-500 p-6">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-green-800 font-bold">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- Payment Confirmation Card --}}
        <div class="bg-white shadow-xl border border-gray-100 overflow-hidden">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-[#1E3A8A] to-[#60A5FA] text-white p-8">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h1 class="font-heading font-black text-3xl md:text-4xl uppercase tracking-tighter mb-2">Order Placed!</h1>
                    <p class="text-blue-100">Your order has been successfully processed</p>
                </div>
            </div>

            {{-- Transaction Info --}}
            <div class="p-8 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1">Transaction Code</p>
                        <p class="font-heading font-bold text-xl text-[#1E3A8A]">{{ $transaction->code }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1">Payment Method</p>
                        <p class="font-bold text-lg">{{ $transaction->payment_method }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1">Status</p>
                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-bold uppercase">{{ $transaction->status }}</span>
                    </div>
                </div>
            </div>

            {{-- DEBUG INFO - Remove after fixing --}}
            <div class="p-4 bg-red-100 border border-red-300 text-sm">
                <p><strong>DEBUG:</strong></p>
                <p>Payment Method: <strong>{{ $transaction->payment_method }}</strong></p>
                <p>Status: <strong>{{ $transaction->status }}</strong></p>
                <p>Condition Check: {{ in_array($transaction->payment_method, ['Transfer', 'Bank Transfer']) && $transaction->status === 'pending' ? 'TRUE - Should show green button' : 'FALSE - Will show blue buttons' }}</p>
            </div>

            {{-- Order Summary --}}
            <div class="p-8 border-b border-gray-200">
                <h2 class="font-heading font-black text-xl uppercase tracking-tight mb-6">Order Summary</h2>
                
                {{-- Items --}}
                <div class="space-y-4 mb-6">
                    @foreach($transaction->details as $detail)
                    <div class="flex gap-4 items-center">
                        <div class="w-16 h-20 bg-gray-100 flex-shrink-0 overflow-hidden rounded">
                            @if($detail->product->images && $detail->product->images->first())
                                @php $img = $detail->product->images->first()->image; @endphp
                                <img src="{{ Str::startsWith($img, 'http') ? $img : asset('storage/' . $img) }}" 
                                     class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-sm">{{ $detail->product->name }}</p>
                            <p class="text-xs text-slate-500">Size: {{ $detail->size }} | Qty: {{ $detail->qty }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Totals --}}
                <div class="border-t border-gray-200 pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($transaction->grand_total - $transaction->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Shipping ({{ $transaction->shipping_type }})</span>
                        <span class="font-medium">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t border-gray-200 pt-4">
                        <span>Total</span>
                        <span class="text-[#1E3A8A]">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Payment Instructions --}}
            <div class="p-8 bg-gray-50">
                <h2 class="font-heading font-black text-xl uppercase tracking-tight mb-6">Payment Instructions</h2>
                
                @if($transaction->payment_method === 'COD')
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-green-100 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                           <div>
                                <h3 class="font-bold text-lg mb-2">Cash on Delivery (COD)</h3>
                                <p class="text-sm text-slate-600 mb-4">Payment will be collected when your order is delivered.</p>
                                <ul class="space-y-2 text-sm text-slate-600">
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Please prepare exact amount of <strong>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</strong>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Payment will be collected by our courier
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        You can track your order status in "My Orders"
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-blue-100 rounded-full">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-lg mb-2">Bank Transfer</h3>
                                <p class="text-sm text-slate-600 mb-4">Please transfer the total amount to the following account:</p>
                                
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                                    <div class="grid grid-cols-1 gap-3">
                                        <div>
                                            <p class="text-xs text-slate-500 uppercase tracking-wide">Bank Name</p>
                                            <p class="font-bold">Bank BCA</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 uppercase tracking-wide">Account Number</p>
                                            <p class="font-bold text-lg font-mono">1234567890</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 uppercase tracking-wide">Account Name</p>
                                            <p class="font-bold">PT WalkUno Indonesia</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 uppercase tracking-wide">Amount</p>
                                            <p class="font-bold text-xl text-[#1E3A8A]">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-sm text-yellow-800"><strong>Important:</strong> Please complete the payment within 24 hours. Your order will be automatically cancelled if payment is not received.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Shipping Address --}}
            <div class="p-8 border-t border-gray-200">
                <h2 class="font-heading font-black text-xl uppercase tracking-tight mb-4">Shipping Address</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm">{{ $transaction->address }}</p>
                    <p class="text-sm text-slate-600">{{ $transaction->city }}, {{ $transaction->postal_code }}</p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="p-8 bg-gray-50">
                {{-- Always show Confirm Payment button if pending --}}
                @if($transaction->status === 'pending')
                    <form action="{{ route('payment.confirm', $transaction->id) }}" method="POST" class="mb-4">
                        @csrf
                        <button type="submit" 
                                style="background: #10b981 !important;" 
                                class="w-full py-5 text-white text-center font-bold uppercase tracking-widest text-base hover:opacity-90 transition-all duration-300 rounded-lg shadow-2xl border-4 border-green-400">
                            ✓ CONFIRM PAYMENT
                        </button>
                    </form>
                @endif

                {{-- Other navigation buttons --}}
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('transaction.history') }}" 
                       class="py-3 bg-gradient-to-r from-[#60A5FA] to-[#1E3A8A] text-white text-center font-bold uppercase tracking-widest text-xs hover:shadow-lg hover:shadow-blue-500/30 transition-all rounded">
                        View My Orders
                    </a>
                    <a href="{{ route('home') }}" 
                       class="py-3 bg-gradient-to-r from-[#60A5FA] to-[#1E3A8A] text-white text-center font-bold uppercase tracking-widest text-xs hover:shadow-lg hover:shadow-blue-500/30 transition-all rounded">
                        Continue Shopping
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection
