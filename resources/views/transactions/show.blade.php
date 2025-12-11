<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Transaction Details</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow-sm">

                {{-- Header Transaksi --}}
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Transaction</div>
                        <div class="font-medium">#{{ $transaction->id }}</div>
                        <div class="text-sm text-gray-500">
                            {{ $transaction->created_at->format('d M Y H:i') }}
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="text-lg font-bold">
                            Rp {{ number_format($transaction->grand_total,0,',','.') }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ ucfirst($transaction->payment_status) }}
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Shipping Address --}}
                <div class="mb-4">
                    <div class="text-sm text-gray-500">Shipping Address</div>
                    <div class="font-medium">{{ $transaction->address }}</div>
                    <div class="text-sm text-gray-500">
                        {{ $transaction->city }}, {{ $transaction->postal_code }}
                    </div>
                </div>

                {{-- Items --}}
                <div class="mb-4">
                    <div class="text-sm text-gray-500">Items</div>

                    <div class="mt-2 space-y-2">
                        @foreach($transaction->transactionDetails as $d)
                            <div class="flex items-center justify-between border p-3 rounded">

                                <div>
                                    <div class="font-medium">
                                        {{ $d->product->name ?? 'Product not found' }}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        Qty: {{ $d->qty }}
                                    </div>
                                </div>

                                {{-- Subtotal dihitung otomatis --}}
                                <div class="text-right">
                                    @php
                                        $subtotal = $d->qty * $d->price;
                                    @endphp

                                    <div class="font-semibold">
                                        Rp {{ number_format($subtotal,0,',','.') }}
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Total --}}
                <div class="text-right">
                    <div class="text-sm text-gray-500">Shipping Cost</div>
                    <div class="font-medium">
                        Rp {{ number_format($transaction->shipping_cost ?? 0,0,',','.') }}
                    </div>

                    <div class="text-sm text-gray-500 mt-2">Grand Total</div>
                    <div class="text-xl font-bold">
                        Rp {{ number_format($transaction->grand_total,0,',','.') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>