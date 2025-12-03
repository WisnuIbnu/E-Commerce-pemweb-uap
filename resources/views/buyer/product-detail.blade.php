@extends('layouts.buyer')

@section('content')

<div class="product-detail">
    <img src="/storage/{{ $product->image }}" style="width:250px; border-radius:10px;">
    <h2>{{ $product->name }}</h2>
    <p>{{ $product->description }}</p>
    <h3>Rp {{ number_format($product->price) }}</h3>

    <form method="POST" action="{{ route('buyer.cart.add', $product->id) }}">
        @csrf
        <button class="btn-orange">Tambah ke Keranjang</button>
    </form>
</div>

@endsection