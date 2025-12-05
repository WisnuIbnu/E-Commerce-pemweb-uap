@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>

    @if (count($cart) > 0)
    <div>
        @foreach ($cart as $item)
        <div class="bg-white rounded-lg p-4 mb-4">
            <div class="flex justify-between">
                <div>
                    <h3 class="font-semibold">{{ $item['name'] }}</h3>
                    <p class="text-sm">Qty: {{ $item['qty'] }}</p>
                </div>
                <div>
                    <p class="text-xl font-bold text-orange-500">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</p>
                    <form action="{{ route('buyer.cart.remove', $item['product_id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-right">
        <p class="text-xl font-bold">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
        <a href="{{ route('buyer.checkout.index') }}" class="mt-4 w-full bg-orange-500 text-white p-2 rounded">Lanjutkan ke Checkout</a>
    </div>
    @else
    <p>Keranjang Anda kosong.</p>
    @endif
</div>
@endsection
