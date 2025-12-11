@extends('admin.layout')

@section('content')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header-title {
        font-size: 22px;
        font-weight: 600;
        margin: 0;
    }

    .page-header-sub {
        font-size: 13px;
        color: #6b7280;
        margin-top: 4px;
    }

    .btn-back,
    .btn-primary {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 13px;
        text-decoration: none;
        border: 1px solid transparent;
    }

    .btn-back {
        border-color: #e5e7eb;
        color: #374151;
        background: #ffffff;
        margin-right: 6px;
    }

    .btn-back:hover {
        background: #f3f4f6;
    }

    .btn-primary {
        background: #ff7a00;
        color: #ffffff;
    }

    .btn-primary:hover {
        background: #ff8f26;
    }

    .card-detail {
        background: #ffffff;
        padding: 22px;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.05);
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        align-items: flex-start;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 120px 1fr;
        row-gap: 10px;
        column-gap: 16px;
        font-size: 14px;
    }

    .detail-label {
        color: #6b7280;
        font-weight: 500;
    }

    .detail-value {
        color: #111827;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        background: #f3f4ff;
        color: #4338ca;
    }

    .product-image-wrapper {
        text-align: center;
    }

    .product-image-wrapper img {
        max-width: 220px;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .product-name {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .product-price {
        font-size: 16px;
        font-weight: 600;
        color: #16a34a;
        margin-bottom: 14px;
    }

    .product-description {
        margin-top: 14px;
        font-size: 14px;
        line-height: 1.6;
        color: #4b5563;
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-header-title">Detail Produk</h1>
        <p class="page-header-sub">{{ $product->name }}</p>
    </div>
</div>

<div class="card-detail">
    {{-- Info kiri --}}
    <div>
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-price">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </div>

        <div class="detail-grid">
            <div class="detail-label">Store</div>
            <div class="detail-value">
                <span class="badge">{{ $product->store->name ?? '-' }}</span>
            </div>

            <div class="detail-label">Category</div>
            <div class="detail-value">
                {{ $product->category->name ?? '-' }}
            </div>

            <div class="detail-label">Stock</div>
            <div class="detail-value">
                {{ $product->stock }}
            </div>
        </div>

        <div class="product-description">
            <strong>Description:</strong><br>
            {{ $product->description ?: '-' }}
        </div>
    </div>

    {{-- Gambar kanan --}}
    <div class="product-image-wrapper">
        @if($product->image)
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
        @else
            <span style="font-size:13px; color:#9ca3af;">Tidak ada gambar</span>
        @endif
    </div>
</div>

@endsection
