@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Produk Tersedia</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ($products as $product)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                <p class="text-gray-600">{{ $product->description }}</p>
                <p class="text-xl font-bold text-orange-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <a href="{{ route('buyer.products.show', $product->id) }}" class="text-orange-500 hover:text-orange-600">Lihat Detail</a>
            </div>
        </div>
        @endforeach
    </div>

    {{ $products->links() }} <!-- Pagination -->
</div>
@endsection
