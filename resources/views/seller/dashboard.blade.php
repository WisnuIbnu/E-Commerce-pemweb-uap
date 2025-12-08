@extends('layouts.seller')

@section('title', 'Seller Dashboard - FlexSport')

@section('content')
<div class="header">
    <div>
        <h1 style="margin: 0; font-size: 2rem;">👋 Welcome, {{ auth()->user()->name }}!</h1>
        <p style="margin: 0.5rem 0 0 0; color: var(--text-muted);">Manage your store and track your business</p>
    </div>
</div>

<!-- Seller Stats -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: var(--darkl); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05);">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📦</div>
        <div style="font-size: 2rem; font-weight: bold; color: var(--primary);">{{ $stats['products_count'] }}</div>
        <div style="color: var(--text-muted);">Total Products</div>
    </div>
    <div style="background: var(--darkl); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05);">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📋</div>
        <div style="font-size: 2rem; font-weight: bold; color: var(--primary);">{{ $stats['transactions_count'] }}</div>
        <div style="color: var(--text-muted);">Total Orders</div>
    </div>
    <div style="background: var(--darkl); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05);">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">💰</div>
        <div style="font-size: 1.3rem; font-weight: bold; color: var(--primary);">Rp {{ number_format($stats['balance'], 0, ',', '.') }}</div>
        <div style="color: var(--text-muted);">Store Balance</div>
    </div>
    <div style="background: var(--darkl); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05);">
        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🛍️</div>
        <div style="font-size: 2rem; font-weight: bold; color: var(--primary);">{{ $stats['buyer_transactions'] }}</div>
        <div style="color: var(--text-muted);">My Purchases</div>
    </div>
</div>

<!-- Products Section -->
<div style="background: var(--darkl); padding: 2rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="margin: 0; font-size: 1.5rem;">Your Products</h2>
        <a href="{{ route('seller.products') }}" class="btn" style="background: var(--primary); color: black; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600;">View All Products</a>
    </div>

    @if($products->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
        @foreach($products as $product)
        <div style="background: rgba(0,0,0,0.3); border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.05);">
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
                <div style="display: flex; gap: 0.5rem; font-size: 0.85rem; color: var(--text-muted);">
                    <span>Stock: {{ $product->stock }}</span>
                    <span>•</span>
                    <span>{{ ucfirst($product->condition) }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
        <div style="font-size: 4rem; margin-bottom: 1rem;">📦</div>
        <h3>No Products Yet</h3>
        <p>Start adding products to your store</p>
        <a href="{{ route('seller.products') }}" class="btn" style="margin-top: 1rem; background: var(--primary); color: black; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; display: inline-block;">Add Product</a>
    </div>
    @endif
</div>

<!-- Quick Actions -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
    <a href="{{ route('seller.orders') }}" style="background: var(--darkl); padding: 2rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); text-decoration: none; color: white; transition: all 0.3s;">
        <div style="font-size: 2.5rem; margin-bottom: 1rem;">📋</div>
        <h3 style="margin: 0 0 0.5rem 0;">Manage Orders</h3>
        <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">View and process customer orders</p>
    </a>
    <a href="{{ route('seller.balance') }}" style="background: var(--darkl); padding: 2rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); text-decoration: none; color: white; transition: all 0.3s;">
        <div style="font-size: 2.5rem; margin-bottom: 1rem;">💰</div>
        <h3 style="margin: 0 0 0.5rem 0;">Balance & Withdrawal</h3>
        <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">Manage your earnings</p>
    </a>
    <a href="{{ route('transaction.history') }}" style="background: var(--darkl); padding: 2rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); text-decoration: none; color: white; transition: all 0.3s;">
        <div style="font-size: 2.5rem; margin-bottom: 1rem;">🛍️</div>
        <h3 style="margin: 0 0 0.5rem 0;">My Purchases</h3>
        <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">View your shopping history</p>
    </a>
</div>
@endsection