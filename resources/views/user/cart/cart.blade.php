@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-serif font-bold text-gray-900 mb-8">Shopping Cart</h1>

    @if($carts->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($carts as $cart)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($cart->product->productImages->first())
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $cart->product->productImages->first()->image) }}" alt="">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-500">Img</div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $cart->product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $cart->product->store->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center border border-gray-300 rounded w-max">
                                    <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $cart->quantity - 1 }}">
                                        <button type="submit" class="px-2 py-1 hover:bg-gray-100 text-gray-600 focus:outline-none" {{ $cart->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                    </form>
                                    
                                    <span class="px-2 text-sm text-gray-900 w-8 text-center">{{ $cart->quantity }}</span>
                                    
                                    <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $cart->quantity + 1 }}">
                                        <button type="submit" class="px-2 py-1 hover:bg-gray-100 text-gray-600 focus:outline-none" {{ $cart->quantity >= $cart->product->stock ? 'disabled' : '' }}>+</button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-end">
            <div class="bg-gray-50 p-6 rounded-lg">
                <div class="flex justify-between mb-4 text-lg font-bold">
                    <span>Total:</span>
                    <span>Rp {{ number_format($carts->sum(fn($c) => $c->product->price * $c->quantity), 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="block bg-black text-white px-8 py-3 rounded hover:bg-gray-800 transition w-full text-center">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 mb-4">Your cart is empty.</p>
            <a href="{{ route('products') }}" class="text-blue-600 hover:underline">Start Shopping</a>
        </div>
    @endif
</div>
@endsection
