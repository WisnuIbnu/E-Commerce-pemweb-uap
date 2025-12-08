@extends('layouts.buyer')

@section('title', 'Checkout - ELSHOP')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('buyer.dashboard') }}">Beranda</a>
    <span>/</span>
    <a href="{{ route('buyer.cart.index') }}">Keranjang</a>
    <span>/</span>
    <span>Checkout</span>
</div>

<div class="section">
    <div class="section-header">
        <h2 class="section-title">💳 Checkout Pesanan</h2>
    </div>

    <form action="{{ route('buyer.checkout.process') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 24px;">
            {{-- Shipping & Payment Info --}}
            <div>
                {{-- Alamat Pengiriman --}}
                <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 20px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                    <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 20px; color: var(--gray-800); display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-map-marker-alt" style="color: var(--accent);"></i>
                        Alamat Pengiriman
                    </h3>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                            Nama Penerima <span style="color: var(--danger);">*</span>
                        </label>
                        <input type="text" name="receiver_name" class="filter-select"
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px;"
                               value="{{ auth()->user()->name }}" required>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                            Nomor Telepon <span style="color: var(--danger);">*</span>
                        </label>
                        <input type="text" name="receiver_phone" class="filter-select"
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px;"
                               value="{{ auth()->user()->phone }}" required>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                            Alamat Lengkap <span style="color: var(--danger);">*</span>
                        </label>
                        <textarea name="shipping_address" rows="3" class="filter-select"
                                  style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px; resize: vertical;"
                                  required>{{ auth()->user()->address }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                                Kota <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="text" name="city" class="filter-select"
                                   style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px;"
                                   value="Malang" required>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--gray-700);">
                                Kode Pos <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="text" name="postal_code" class="filter-select"
                                   style="width: 100%; padding: 12px 16px; border: 1px solid var(--accent-light); border-radius: 8px;"
                                   required>
                        </div>
                    </div>
                </div>

                {{-- Metode Pengiriman --}}
                <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 20px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                    <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 20px; color: var(--gray-800); display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-truck" style="color: var(--accent);"></i>
                        Metode Pengiriman
                    </h3>

                    <div style="display: grid; gap: 12px;">
                        <label style="display: flex; align-items: center; padding: 16px; border: 2px solid var(--accent-light); border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="shipping_method" value="regular" checked style="margin-right: 12px;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; margin-bottom: 4px;">JNE Regular</div>
                                <div style="font-size: 0.875rem; color: var(--gray-600);">Estimasi 2-3 hari</div>
                            </div>
                            <div style="font-weight: 700; color: var(--primary);">Rp 15.000</div>
                        </label>

                        <label style="display: flex; align-items: center; padding: 16px; border: 2px solid var(--accent-light); border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="shipping_method" value="express" style="margin-right: 12px;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; margin-bottom: 4px;">JNE Express</div>
                                <div style="font-size: 0.875rem; color: var(--gray-600);">Estimasi 1 hari</div>
                            </div>
                            <div style="font-weight: 700; color: var(--primary);">Rp 25.000</div>
                        </label>

                        <label style="display: flex; align-items: center; padding: 16px; border: 2px solid var(--accent-light); border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="shipping_method" value="same-day" style="margin-right: 12px;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; margin-bottom: 4px;">Same Day</div>
                                <div style="font-size: 0.875rem; color: var(--gray-600);">Hari ini juga</div>
                            </div>
                            <div style="font-weight: 700; color: var(--primary);">Rp 35.000</div>
                        </label>
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                    <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 20px; color: var(--gray-800); display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-credit-card" style="color: var(--accent);"></i>
                        Metode Pembayaran
                    </h3>

                    <div style="display: grid; gap: 12px;">
                        <label style="display: flex; align-items: center; padding: 16px; border: 2px solid var(--accent-light); border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="payment_method" value="transfer" checked style="margin-right: 12px;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; margin-bottom: 4px;">Transfer Bank</div>
                                <div style="font-size: 0.875rem; color: var(--gray-600);">BCA, Mandiri, BNI</div>
                            </div>
                        </label>

                        <label style="display: flex; align-items: center; padding: 16px; border: 2px solid var(--accent-light); border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="payment_method" value="ewallet" style="margin-right: 12px;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; margin-bottom: 4px;">E-Wallet</div>
                                <div style="font-size: 0.875rem; color: var(--gray-600);">OVO, GoPay, DANA</div>
                            </div>
                        </label>

                        <label style="display: flex; align-items: center; padding: 16px; border: 2px solid var(--accent-light); border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="payment_method" value="cod" style="margin-right: 12px;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; margin-bottom: 4px;">COD (Bayar di Tempat)</div>
                                <div style="font-size: 0.875rem; color: var(--gray-600);">Bayar saat barang sampai</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div>
                <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light); position: sticky; top: 100px;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 20px; color: var(--gray-800);">
                        Ringkasan Pesanan
                    </h3>

                    @if(isset($items))
                        @php
                            $subtotal = $items->sum(function($item) {
                                return $item->product->price * $item->quantity;
                            });
                            $shipping = 15000; // Default regular
                            $total = $subtotal + $shipping;
                        @endphp

                        {{-- Items --}}
                        <div style="margin-bottom: 20px; max-height: 300px; overflow-y: auto;">
                            @foreach($items as $item)
                                <div style="display: flex; gap: 12px; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--accent-light);">
                                    @if($item->product->images && $item->product->images->count() > 0)
                                        <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" 
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div style="width: 60px; height: 60px; background: var(--gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            📦
                                        </div>
                                    @endif
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; font-size: 0.875rem; margin-bottom: 4px;">
                                            {{ Str::limit($item->product->name, 30) }}
                                        </div>
                                        <div style="font-size: 0.813rem; color: var(--gray-600);">
                                            {{ $item->quantity }}x Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pricing --}}
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--accent-light);">
                            <span style="color: var(--gray-600);">Subtotal ({{ $items->sum('quantity') }} item)</span>
                            <span style="font-weight: 600;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div style="display: flex; justify-content: space-between; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 2px solid var(--accent-light);">
                            <span style="color: var(--gray-600);">Ongkos Kirim</span>
                            <span style="font-weight: 600;" id="shippingCost">Rp 15.000</span>
                        </div>

                        <div style="display: flex; justify-content: space-between; margin-bottom: 24px;">
                            <span style="font-size: 1.125rem; font-weight: 700;">Total Pembayaran</span>
                            <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary);" id="totalAmount">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>

                        <button type="submit" 
                                style="width: 100%; background: var(--accent); color: white; border: none; padding: 14px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: var(--shadow-md);">
                            <i class="fas fa-check-circle"></i> Buat Pesanan
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<style>
label:has(input[type="radio"]:checked) {
    border-color: var(--accent) !important;
    background: var(--accent-lightest);
}

button[type="submit"]:hover {
    background: var(--primary) !important;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}
</style>

<script>
// Update shipping cost dinamis
document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const costs = {
            'regular': 15000,
            'express': 25000,
            'same-day': 35000
        };
        
        const subtotal = {{ $subtotal ?? 0 }};
        const shipping = costs[this.value];
        const total = subtotal + shipping;
        
        document.getElementById('shippingCost').textContent = 'Rp ' + shipping.toLocaleString('id-ID');
        document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
    });
});
</script>
@endsection