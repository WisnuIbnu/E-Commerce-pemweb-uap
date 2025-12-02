@extends('layouts.seller')

@section('title', 'Dashboard')

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="card p-4 shadow-sm">
            <h5>Total Produk</h5>
            <h2>{{ $totalProducts }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4 shadow-sm">
            <h5>Pesanan Masuk</h5>
            <h2>{{ $totalOrders }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4 shadow-sm">
            <h5>Saldo</h5>
            <h2>Rp {{ number_format($balance,0,',','.') }}</h2>
        </div>
    </div>
</div>

@endsection
