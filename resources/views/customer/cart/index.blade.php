{{-- resources/views/customer/cart/index.blade.php --}}
<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 px-6 py-8 shadow-xl">
            <div class="relative z-10 flex flex-col gap-3">
                <div class="inline-flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-2xl">
                        🛒
                    </span>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-blue-100">
                            Shopping Cart
                        </p>
                        <h2 class="font-semibold text-2xl md:text-3xl text-white">
                            My Cart
                        </h2>
                    </div>
                </div>

                <p class="text-sm md:text-base text-blue-100 max-w-2xl">
                    Tinjau produk di keranjang sebelum melanjutkan ke checkout.
                </p>
            </div>

            <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-blue-300/30 blur-3xl"></div>
            <div class="pointer-events-none absolute left-10 -bottom-16 h-48 w-48 rounded-full bg-white/10 blur-3xl"></div>
        </div>
    </x-slot>

    {{-- MAIN CONTENT --}}
    <div class="bg-gray-900 min-h-screen text-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ALERTS --}}
            @if(session('success'))
                <div class="bg-green-500/20 border border-green-400 text-green-100 px-4 py-2 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-500/20 border border-red-400 text-red-100 px-4 py-2 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if(empty($items))
                <p class="text-gray-400">
                    Keranjangmu masih kosong.
                </p>
            @else
                {{-- LIST ITEM CART --}}
                <div class="space-y-4">
                    @foreach($items as $row)
                        @php
                            $product = $row['product'];
                        @endphp

                        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 rounded-lg bg-gray-800 flex items-center justify-center overflow-hidden">
                                    @if(method_exists($product, 'images') && $product->images->first())
                                        <img src="{{ asset('storage/'.$product->images->first()->image) }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-contain">
                                    @else
                                        <span class="text-xs text-gray-400">No Image</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-100">
                                        {{ $product->name }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        Price: Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        Qty: {{ $row['qty'] }}
                                    </p>
                                    <p class="text-sm text-blue-300 mt-1">
                                        Subtotal: Rp {{ number_format($row['sub'], 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- Update qty --}}
                                <form action="{{ route('cart.update', $product->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="number" name="qty" min="1" value="{{ $row['qty'] }}"
                                           class="w-16 bg-gray-900 border border-gray-700 rounded-lg text-sm px-2 py-1 text-gray-100">
                                    <button type="submit"
                                            class="text-xs bg-blue-500 hover:bg-blue-400 text-white px-3 py-1 rounded-lg">
                                        Update
                                    </button>
                                </form>

                                {{-- Remove --}}
                                <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="text-xs bg-red-500 hover:bg-red-400 text-white px-3 py-1 rounded-lg">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- SUMMARY + CHECKOUT --}}
                <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="text-gray-200">
                        <p class="text-sm">Total:</p>
                        <p class="text-2xl font-bold text-blue-300">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </p>
                    </div>

                    <a href="{{ route('checkout') }}"
                       class="inline-flex items-center justify-center bg-green-500 hover:bg-green-400 text-white px-6 py-2 rounded-lg text-sm font-semibold shadow">
                        Proceed to Checkout
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
