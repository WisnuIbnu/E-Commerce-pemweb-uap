@extends('layouts.buyer')
@section('title','Products')

@section('content')
<h1>All Products</h1>
@foreach($products as $p)
    <div>
        <a href="{{ route('buyer.product.show', $p->id) }}">{{ $p->name }}</a>
    </div>
@endforeach
@endsection
