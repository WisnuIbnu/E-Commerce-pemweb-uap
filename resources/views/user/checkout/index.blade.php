<x-user-layout title="Checkout">

<div class="container py-8 max-w-4xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- SHIPPING FORM --}}
        <div class="p-6 bg-white shadow rounded-lg border">
            <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <label class="font-medium">Alamat Lengkap</label>
                <input type="text" name="address" class="border w-full mb-4 p-2 rounded" required>

                <label class="font-medium">Kota</label>
                <input type="text" name="city" class="border w-full mb-4 p-2 rounded" required>

                <label class="font-medium">Kode Pos</label>
                <input type="text" name="postal_code" class="border w-full mb-4 p-2 rounded" required>

                <label class="font-medium">Jenis Pengiriman</label>
                <select name="shipping_type" class="border w-full mb-4 p-2 rounded" required>
                    <option value="regular">Regular — Rp 20.000</option>
                    <option value="express">Express — Rp 35.000</option>
                </select>

                <button class="w-full bg-sweet-500 text-white font-semibold py-3 rounded-lg hover:bg-sweet-600">
                    Bayar Sekarang
                </button>
            </form>
        </div>

        {{-- ORDER SUMMARY --}}
        <div class="p-6 bg-white shadow rounded-lg border">

            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

            @php $subtotal = 0; @endphp

            @foreach ($products as $p)
                @php
                    $qty = $cart[$p->id]['qty'];
                    $lineTotal = $p->price * $qty;
                    $subtotal += $lineTotal;
                @endphp

                <div class="flex justify-between border-b py-3">
                    <div>
                        <p class="font-semibold">{{ $p->name }}</p>
                        <p class="text-sm text-gray-600">Qty: {{ $qty }}</p>
                    </div>
                    <p>Rp {{ number_format($lineTotal, 0, ',', '.') }}</p>
                </div>
            @endforeach

            @php
                $shipping = 20000;
                $tax = $subtotal * 0.1;
                $total = $subtotal + $shipping + $tax;
            @endphp

            <div class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Pajak (10%)</span>
                    <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Shipping</span>
                    <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                </div>

                <hr class="my-2">

                <div class="flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

        </div>

    </div>

</div>

</x-user-layout>
