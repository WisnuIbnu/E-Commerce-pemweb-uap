@extends('layouts.app')

@section('title', 'Keranjang Belanja - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-tumbloo-white mb-8">Keranjang Belanja</h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-900/50 border border-green-500 rounded-lg text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-900/50 border border-red-500 rounded-lg text-red-200">
                {{ session('error') }}
            </div>
        @endif

        @if($cartItems->isEmpty())
            <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-tumbloo-gray mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-tumbloo-white mb-2">Keranjang Kosong</h2>
                <p class="text-tumbloo-gray mb-6">Belum ada produk di keranjang Anda</p>
                <a href="{{ route('home') }}" class="inline-block bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold py-3 px-6 rounded-lg transition">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6">
                            <div class="flex gap-4">
                                <div class="w-24 h-24 rounded-lg overflow-hidden bg-tumbloo-dark flex-shrink-0">
                                    @if($item->product->images->isNotEmpty())
                                        <img src="{{ asset($item->product->images->first()->image) }}" 
                                             alt="{{ $item->product->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between mb-2">
                                        <div>
                                            <h3 class="text-tumbloo-white font-semibold mb-1">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-tumbloo-gray">{{ $item->product->store->name }}</p>
                                        </div>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="text-blue-200 font-bold">
                                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                        </div>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" onclick="decreaseQty({{ $item->id }})" 
                                                    class="w-8 h-8 bg-tumbloo-dark hover:bg-tumbloo-accent text-tumbloo-white rounded flex items-center justify-center transition">
                                                -
                                            </button>
                                            <input type="number" 
                                                   name="quantity" 
                                                   id="qty-{{ $item->id }}"
                                                   value="{{ $item->quantity }}" 
                                                   min="1"
                                                   max="{{ $item->product->stock }}"
                                                   class="w-16 text-center bg-tumbloo-dark border border-tumbloo-accent rounded text-tumbloo-white py-1">
                                            <button type="button" onclick="increaseQty({{ $item->id }}, {{ $item->product->stock }})" 
                                                    class="w-8 h-8 bg-tumbloo-dark hover:bg-tumbloo-accent text-tumbloo-white rounded flex items-center justify-center transition">
                                                +
                                            </button>
                                            <button type="submit" class="ml-2 text-xs bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white px-3 py-1 rounded transition">
                                                Update
                                            </button>
                                        </form>
                                    </div>

                                    <div class="mt-2 text-right">
                                        <span class="text-sm text-tumbloo-gray">Subtotal: </span>
                                        <span class="text-blue-500 font-semibold">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <form action="{{ route('cart.clear') }}" method="POST" class="text-center">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition">
                            Kosongkan Keranjang
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-tumbloo-white mb-4">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-tumbloo-gray">
                                <span>Subtotal</span>
                                <span class="text-blue-200">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-tumbloo-gray">
                                <span>Items</span>
                                <span class="text-blue-200">{{ $cartItems->count() }} produk</span>
                            </div>
                        </div>

                        <div class="border-t border-tumbloo-accent pt-4 mb-6">
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-tumbloo-white">Total</span>
                                <span class="text-blue-500">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" 
                           class="block w-full bg-green-400 hover:bg-green-600 text-white text-center font-semibold py-3 px-4 rounded-lg transition transform hover:scale-105">
                            Lanjut ke Checkout
                        </a>

                        <a href="{{ route('home') }}" 
                           class="block w-full text-center text-blue-300 hover:text-tumbloo-white mt-3 transition">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function decreaseQty(cartItemId) {
    const input = document.getElementById(`qty-${cartItemId}`);
    if (input.value > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function increaseQty(cartItemId, maxStock) {
    const input = document.getElementById(`qty-${cartItemId}`);
    if (input.value < maxStock) {
        input.value = parseInt(input.value) + 1;
    }
}
</script>
@endsection