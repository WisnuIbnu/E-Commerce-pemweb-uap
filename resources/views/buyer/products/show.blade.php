@extends('layouts.buyer')
@section('title','Product Detail')

@section('content')
<h1>{{ $product->name }}</h1>
<p>{{ $product->description }}</p>

<form action="{{ route('buyer.cart.add') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $product->id }}">
    <button type="submit">Add to Cart</button>
</form>
@endsection
