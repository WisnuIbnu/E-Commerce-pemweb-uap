@extends('layouts.buyer')

@section('content')
<h2>Semua Produk Keripik</h2>

<div class="product-grid">
    @foreach ($products as $product)
    <div class="product-card">
        <img src="/storage/{{ $product->image }}" alt="">
        <h3>{{ $product->name }}</h3>
        <p>Rp {{ number_format($product->price) }}</p>

        <a href="{{ route('buyer.product.detail', $product->id) }}" class="btn-orange">Detail</a>
    </div>
    @endforeach
</div>
@endsection