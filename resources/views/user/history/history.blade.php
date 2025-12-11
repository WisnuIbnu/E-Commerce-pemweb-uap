<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Purchase History</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-noise text-gray-700 antialiased">

    {{-- NAVBAR --}}
    @include('layouts.user.store-navbar')

    {{-- PAGE WRAPPER --}}
    <main class="px-16 py-8">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Title --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Purchase History</h1>
                <p class="text-sm text-gray-500 mt-1">Track all your past transactions in one place.</p>
            </div>
        </div>

        {{-- HISTORY LIST WRAPPER --}}
        <section class="space-y-6">

            @forelse ($transactions as $transaction)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    {{-- Header --}}
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-wrap justify-between items-center gap-4">
                        <div class="flex items-center gap-4 text-sm">
                            <span class="font-bold text-gray-900">{{ $transaction->created_at->format('d M Y') }}</span>
                            <span class="text-gray-400">|</span>
                            <span>{{ $transaction->code }}</span>
                            <span class="text-gray-400">|</span>
                            <span class="font-medium text-gray-700">{{ $transaction->store->name ?? 'Store Unknown' }}</span>
                        </div>
                        <div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                {{ $transaction->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($transaction->payment_status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {{-- Items --}}
                            <div class="md:col-span-2 space-y-4">
                                @foreach($transaction->transactionDetails as $detail)
                                    <div class="flex gap-4">
                                        @if($detail->product && $detail->product->productImages->first())
                                            <img src="{{ asset('storage/' . $detail->product->productImages->first()->image) }}" 
                                                 class="w-16 h-16 object-cover rounded-md border border-gray-100">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center text-xs text-gray-400">No Img</div>
                                        @endif
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $detail->product->name ?? 'Product Deleted' }}</h4>
                                            <p class="text-sm text-gray-500">{{ $detail->qty }} x Rp {{ number_format($detail->product->price ?? 0, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Details --}}
                            <div class="md:col-span-1 border-l border-gray-100 pl-0 md:pl-6 space-y-3 text-sm">
                                <div>
                                    <span class="block text-gray-500 text-xs uppercase tracking-wider">Shipping To</span>
                                    <p class="font-medium text-gray-900">{{ $transaction->address }}, {{ $transaction->city }} {{ $transaction->postal_code }}</p>
                                    <p class="text-gray-500 text-xs mt-1">Via: {{ $transaction->shipping_type ?? 'Regular' }} (Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }})</p>
                                </div>
                                
                                <div class="pt-3 border-t border-gray-100">
                                    <span class="block text-gray-500 text-xs uppercase tracking-wider">Total Amount</span>
                                    <p class="text-xl font-bold text-gray-900">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p class="text-lg">You haven't placed any orders yet.</p>
                    <a href="{{ route('products') }}" class="inline-block mt-4 text-black font-medium hover:underline">Start Shopping</a>
                </div>
            @endforelse

        </section>

    </main>

</body>
</html>
