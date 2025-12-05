@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover">
        </div>
        <div>
            <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
            <p class="text-2xl font-bold text-orange-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

            <form action="{{ route('buyer.cart.add') }}" method="POST" class="mt-6">
                @csrf
                <input type="number" name="qty" value="1" min="1" class="w-24 p-2 border rounded">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="mt-4 w-full bg-orange-500 text-white p-2 rounded">Tambah ke Keranjang</button>
            </form>
        </div>
    </div>
</div>
@endsection
