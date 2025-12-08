@extends('layouts.seller')

@section('title', 'Products - Seller')

@section('content')
<div class="header">
    <div>
        <h1 style="margin: 0; font-size: 2rem;">📦 Your Products</h1>
        <p style="margin: 0.5rem 0 0 0; color: var(--text-muted);">Manage y our store inventory</p>
    </div>
</div>

@if(isset($products) && $products->count() > 0)
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
    @foreach($products as $product)
    <div style="background: var(--darkl); border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05);">
        <div style="height: 200px; background: #222; display: flex; align-items: center; justify-content: center;">
            @if($product->productImages->first())
            <img src="{{ $product->productImages->first()->image }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
            <span style="font-size: 3rem;">📦</span>
            @endif
        </div>
        <div style="padding: 1rem;">
            <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem;">{{ $product->name }}</h3>
            <div style="color: var(--primary); font-weight: bold; font-size: 1.2rem; margin-bottom: 0.5rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <div style="display: flex; gap: 0.5rem; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">
                <span>Stock: {{ $product->stock }}</span>
                <span>•</span>
                <span>{{ ucfirst($product->condition) }}</span>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('product.detail', $product->id) }}" class="btn" style="flex: 1; background: rgba(0,242,254,0.1); color: var(--primary); padding: 0.5rem; border-radius: 6px; text-decoration: none; text-align: center; font-size: 0.9rem;">View</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div style="text-align: center; padding: 4rem; background: var(--darkl); border-radius: 16px;">
    <div style="font-size: 4rem; margin-bottom: 1rem;">📦</div>
    <h3 style="margin: 0 0 0.5rem 0;">No Products Yet</h3>
    <p style="margin: 0; color: var(--text-muted);">Start adding products to your store</p>
</div>
@endif
@endsection