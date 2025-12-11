<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Checkout</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">

            {{-- USER ADDRESS --}}
            <div class="mb-6">
                <h3 class="font-semibold mb-1">Shipping Address</h3>
                <div class="text-gray-700">
                    {{ auth()->user()->name }} <br>
                    {{ auth()->user()->address ?? 'No address available' }} <br>
                    {{ auth()->user()->city ?? '-' }},
                    {{ auth()->user()->postal_code ?? '-' }}
                </div>
            </div>

            <hr class="my-4">

            {{-- PRODUCT LIST --}}
            <h3 class="font-semibold mb-2">Purchased Products</h3>
            <div class="space-y-3">
                @foreach($cartItems as $item)
                    <div class="flex justify-between border p-3 rounded">
                        <div>
                            <div class="font-medium">{{ $item->product->name }}</div>
                            <div class="text-sm text-gray-600">
                                Qty: {{ $item->qty }} × Rp {{ number_format($item->product->price) }}
                            </div>
                        </div>
                        <div class="font-bold">
                            Rp {{ number_format($item->product->price * $item->qty) }}
                        </div>

                        {{-- REMOVE BUTTON (DELETE) --}}
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                Remove
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <hr class="my-4">

            {{-- SHIPPING METHOD --}}
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <h3 class="font-semibold">Shipping Method</h3>
                <select name="shipping_type" id="shippingType" class="mt-2 w-full border p-2 rounded">
                    <option value="regular" data-cost="15000">Regular — Rp 15,000</option>
                    <option value="express" data-cost="25000">Express — Rp 25,000</option>
                </select>

                <hr class="my-4">

                {{-- PAYMENT METHOD --}}
                <h3 class="font-semibold">Payment Method</h3>
                <select name="payment_method" class="mt-2 w-full border p-2 rounded">
                    <option value="cod">Cash on Delivery</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="ewallet">E-Wallet</option>
                </select>

                <hr class="my-4">

                {{-- PRICE SUMMARY --}}
                <h3 class="font-semibold mb-2">Payment Summary</h3>

                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Service Fee</span>
                        <span>Rp {{ number_format($serviceFee) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span id="shippingCost">Rp 15,000</span>
                    </div>

                    <div class="flex justify-between font-bold text-lg mt-2">
                        <span>Total</span>
                        <span id="grandTotal">
                            Rp {{ number_format($subtotal + $serviceFee + 15000) }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('checkout.index') }}" method="POST" class="mt-6 flex justify-end">
                    <button type="submit"
                            class="bg-green-600 text-white px-6 py-3 rounded shadow hover:bg-green-700">
                        Checkout
                    </button>
                </form>
            </form>
        </div>
    </div>

    @vite('resources/js/checkout.js')

</x-app-layout>
