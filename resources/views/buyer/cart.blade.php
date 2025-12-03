@extends('layouts.buyer')

@section('content')
<h2>Keranjang Belanja</h2>

@foreach ($cart as $item)
<div class="product-card" style="margin-bottom: 15px;">
    <h3>{{ $item->product->name }}</h3>
    <p>Qty: {{ $item->quantity }}</p>
    <p>Subtotal: Rp {{ number_format($item->product->price * $item->quantity) }}</p>
</div>
@endforeach

<a href="{{ route('buyer.checkout') }}" class="btn-orange">Checkout</a>
@endsection