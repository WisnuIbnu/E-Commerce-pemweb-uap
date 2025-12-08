@extends('layouts.buyer')

@section('title', 'Keranjang Belanja - ELSHOP')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('buyer.dashboard') }}">Beranda</a>
    <span>/</span>
    <span>Keranjang Belanja</span>
</div>

<div class="section">
    <div class="section-header">
        <h2 class="section-title">🛒 Keranjang Belanja</h2>
    </div>

    @if(isset($cartItems) && $cartItems->count() > 0)
        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 24px;">
            {{-- Cart Items --}}
            <div>
                @foreach($cartItems as $item)
                    <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 16px; box-shadow: var(--shadow); border: 1px solid var(--accent-light); display: flex; gap: 20px;">
                        {{-- Product Image --}}
                        <div style="flex-shrink: 0;">
                            @if($item->product->images && $item->product->images->count() > 0)
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" 
                                     alt="{{ $item->product->name }}"
                                     style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div style="width: 120px; height: 120px; background: var(--gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                    📦
                                </div>
                            @endif
                        </div>

                        {{-- Product Info --}}
                        <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 8px;">
                                    <a href="{{ route('buyer.products.show', $item->product->id) }}" style="color: var(--gray-800); text-decoration: none;">
                                        {{ $item->product->name }}
                                    </a>
                                </h3>
                                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 12px;">
                                    <i class="fas fa-store"></i> {{ $item->product->store->name }}
                                </p>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                {{-- Price --}}
                                <div>
                                    <div style="font-size: 1.375rem; font-weight: 700; color: var(--primary);">
                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </div>
                                    <div style="font-size: 0.813rem; color: var(--gray-500);">
                                        per item
                                    </div>
                                </div>

                                {{-- Quantity Controls --}}
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <form action="{{ route('buyer.cart.update', $item->id) }}" method="POST" style="display: flex; align-items: center; gap: 8px; background: var(--gray-100); border-radius: 8px; padding: 4px;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="action" value="decrease" 
                                                style="background: white; border: none; width: 32px; height: 32px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--gray-700); transition: all 0.2s;">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <span style="font-weight: 600; min-width: 30px; text-align: center;">{{ $item->quantity }}</span>
                                        <button type="submit" name="action" value="increase"
                                                style="background: white; border: none; width: 32px; height: 32px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--gray-700); transition: all 0.2s;">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>

                                    {{-- Remove Button --}}
                                    <form action="{{ route('buyer.cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus produk dari keranjang?')"
                                                style="background: none; border: none; color: var(--danger); cursor: pointer; padding: 8px; transition: all 0.2s;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Subtotal --}}
                            <div style="text-align: right; margin-top: 8px; padding-top: 8px; border-top: 1px solid var(--accent-light);">
                                <span style="color: var(--gray-600); font-size: 0.875rem;">Subtotal: </span>
                                <span style="font-weight: 700; color: var(--primary); font-size: 1.125rem;">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Order Summary --}}
            <div>
                <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light); position: sticky; top: 100px;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 20px; color: var(--gray-800);">
                        Ringkasan Belanja
                    </h3>

                    @php
                        $subtotal = $cartItems->sum(function($item) {
                            return $item->product->price * $item->quantity;
                        });
                    @endphp

                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--accent-light);">
                        <span style="color: var(--gray-600);">Total Item</span>
                        <span style="font-weight: 600;">{{ $cartItems->sum('quantity') }} item</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--accent-light);">
                        <span style="color: var(--gray-600);">Subtotal</span>
                        <span style="font-weight: 600;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 2px solid var(--accent-light);">
                        <span style="color: var(--gray-600);">Ongkos Kirim</span>
                        <span style="font-weight: 600; color: var(--success);">Hitung di checkout</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 24px;">
                        <span style="font-size: 1.125rem; font-weight: 700; color: var(--gray-800);">Total</span>
                        <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ route('buyer.checkout.index') }}" 
                       style="display: block; width: 100%; background: var(--accent); color: white; padding: 14px; border-radius: 8px; text-align: center; font-weight: 600; text-decoration: none; transition: all 0.2s; box-shadow: var(--shadow-md);">
                        <i class="fas fa-shopping-bag"></i> Checkout Sekarang
                    </a>

                    <a href="{{ route('buyer.products.index') }}" 
                       style="display: block; width: 100%; margin-top: 12px; background: white; color: var(--gray-700); border: 2px solid var(--accent-light); padding: 12px; border-radius: 8px; text-align: center; font-weight: 600; text-decoration: none; transition: all 0.2s;">
                        <i class="fas fa-arrow-left"></i> Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🛒</div>
            <h3 class="empty-title">Keranjang Belanja Kosong</h3>
            <p class="empty-text">Anda belum menambahkan produk ke keranjang</p>
            <a href="{{ route('buyer.products.index') }}" 
               style="display: inline-block; background: var(--accent); color: white; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 16px; box-shadow: var(--shadow-md); transition: all 0.2s;">
                <i class="fas fa-shopping-bag"></i> Mulai Belanja
            </a>
        </div>
    @endif
</div>

<style>
a[href*="checkout"]:hover,
a[href*="products"]:hover {
    transform: translateY(-2px);
}

a[href*="checkout"]:hover {
    background: var(--primary) !important;
    box-shadow: var(--shadow-lg);
}

a[href*="products"]:hover {
    background: var(--accent-lightest) !important;
    border-color: var(--accent);
}

button:hover {
    background: var(--accent-lightest) !important;
    color: var(--primary) !important;
}

form button[name="action"]:hover {
    background: var(--accent) !important;
    color: white !important;
}
</style>
@endsection