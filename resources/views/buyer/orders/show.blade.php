@extends('layouts.buyer')

@section('title', 'Detail Pesanan - ELSHOP')

@section('content')
<div class="section">
    <!-- Breadcrumb -->
    <div style="margin-bottom: 24px; font-size: 0.938rem; max-width: 900px; margin-left: auto; margin-right: auto;">
        <a href="{{ route('buyer.dashboard') }}" style="color: var(--accent); text-decoration: none;">Beranda</a>
        <span> / </span>
        <a href="{{ route('buyer.orders.index') }}" style="color: var(--accent); text-decoration: none;">Pesanan Saya</a>
        <span> / </span>
        <span style="color: var(--gray-600);">Detail Pesanan</span>
    </div>

    <div style="max-width: 900px; margin: 0 auto;">
        
        <!-- Order Header -->
        <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
            <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 16px; margin-bottom: 16px;">
                <div>
                    <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--gray-900); margin-bottom: 8px;">
                        Order {{ $order->code }}
                    </h1>
                    <p style="color: var(--gray-600); font-size: 0.938rem;">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>

                @php
                    $statusConfig = [
                        'unpaid' => ['color' => 'var(--warning)', 'text' => 'Menunggu Pembayaran'],
                        'paid' => ['color' => 'var(--accent)', 'text' => 'Diproses'],
                        'shipped' => ['color' => 'var(--info)', 'text' => 'Dikirim'],
                        'completed' => ['color' => 'var(--success)', 'text' => 'Selesai'],
                        'cancelled' => ['color' => 'var(--danger)', 'text' => 'Dibatalkan']
                    ];
                    $status = $statusConfig[$order->payment_status] ?? $statusConfig['unpaid'];
                @endphp
                <span style="background: {{ $status['color'] }}22; color: {{ $status['color'] }}; padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                    {{ $status['text'] }}
                </span>
            </div>
        </div>

        <!-- Order Items -->
        <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 20px;">
                Detail Produk
            </h3>

            @if($order->transactionDetails && $order->transactionDetails->count() > 0)
                @foreach($order->transactionDetails as $item)
                    <div style="display: flex; gap: 16px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid var(--accent-light);">
                        @if($item->product && $item->product->images && $item->product->images->count() > 0)
                            <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" 
                                 alt="{{ $item->product->name }}"
                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
                        @else
                            <div style="width: 100px; height: 100px; background: var(--gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--gray-400); flex-shrink: 0;">
                                ?
                            </div>
                        @endif
                        
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-weight: 600; margin-bottom: 8px;">
                                <a href="{{ route('buyer.products.show', $item->product->id) }}" style="color: var(--gray-800); text-decoration: none;">
                                    {{ $item->product->name ?? 'Produk' }}
                                </a>
                            </h4>
                            <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 12px;">
                                SKU: {{ $item->product->sku ?? '-' }}
                            </p>
                            <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                                <span style="color: var(--gray-600);">
                                    {{ $item->qty }}x Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}
                                </span>
                                <span style="font-weight: 700; color: var(--primary);">
                                    Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p style="color: var(--gray-500); text-align: center; padding: 40px;">
                    Tidak ada item dalam pesanan ini
                </p>
            @endif
        </div>

        <!-- Shipping Info -->
        <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
            <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: 20px;">
                Informasi Pengiriman
            </h3>

            <div style="display: grid; gap: 16px;">
                <div>
                    <label style="color: var(--gray-600); font-size: 0.875rem; font-weight: 600; display: block; margin-bottom: 4px;">
                        Alamat Pengiriman
                    </label>
                    <p style="color: var(--gray-800);">{{ $order->address }}</p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                    <div>
                        <label style="color: var(--gray-600); font-size: 0.875rem; font-weight: 600; display: block; margin-bottom: 4px;">
                            Kota
                        </label>
                        <p style="color: var(--gray-800);">{{ $order->city }}</p>
                    </div>
                    <div>
                        <label style="color: var(--gray-600); font-size: 0.875rem; font-weight: 600; display: block; margin-bottom: 4px;">
                            Kode Pos
                        </label>
                        <p style="color: var(--gray-800);">{{ $order->postal_code }}</p>
                    </div>
                </div>

                <div>
                    <label style="color: var(--gray-600); font-size: 0.875rem; font-weight: 600; display: block; margin-bottom: 4px;">
                        Metode Pengiriman
                    </label>
                    <p style="color: var(--gray-800); text-transform: capitalize;">
                        {{ $order->shipping_type }} - Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                    </p>
                </div>

                @if($order->tracking_number)
                <div>
                    <label style="color: var(--gray-600); font-size: 0.875rem; font-weight: 600; display: block; margin-bottom: 4px;">
                        Nomor Resi
                    </label>
                    <p style="color: var(--gray-800); font-family: monospace; font-weight: 600;">
                        {{ $order->tracking_number }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        <!-- Order Summary -->
        <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%); border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: var(--shadow-lg); color: white;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 20px;">
                Ringkasan Pembayaran
            </h3>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.2);">
                    <span>Subtotal</span>
                    <span style="font-weight: 600;">Rp {{ number_format($order->grand_total - $order->shipping_cost - $order->tax, 0, ',', '.') }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.2);">
                    <span>Ongkos Kirim</span>
                    <span style="font-weight: 600;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid rgba(255,255,255,0.2);">
                    <span>Pajak</span>
                    <span style="font-weight: 600;">Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 1.25rem; font-weight: 700;">Total Pembayaran</span>
                    <span style="font-size: 1.75rem; font-weight: 700;">
                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div style="display: grid; gap: 12px;">
            @if($order->payment_status == 'unpaid')
                <form id="payment-form" action="{{ route('buyer.orders.payment', $order->id) }}" method="POST">
                    @csrf
                    <button type="button" onclick="document.getElementById('payment-form').submit();" 
                            style="width: 100%; background: var(--accent); color: white; border: none; padding: 14px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-size: 1rem;">
                        Bayar Sekarang
                    </button>
                </form>
                
                <form id="cancel-form" action="{{ route('buyer.orders.cancel', $order->id) }}" method="POST">
                    @csrf
                    <button type="button" onclick="if(confirm('Batalkan pesanan ini?')) { document.getElementById('cancel-form').submit(); }" 
                            style="width: 100%; background: white; color: var(--danger); border: 2px solid var(--danger); padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-size: 1rem;">
                        Batalkan Pesanan
                    </button>
                </form>
            @elseif($order->payment_status == 'paid')
                <div style="background: var(--success); color: white; padding: 14px; border-radius: 8px; text-align: center; font-weight: 600;">
                    Pembayaran Diterima - Sedang Diproses
                </div>
            @elseif($order->payment_status == 'shipped')
                <form id="confirm-form" action="{{ route('buyer.orders.confirm', $order->id) }}" method="POST">
                    @csrf
                    <button type="button" onclick="document.getElementById('confirm-form').submit();" 
                            style="width: 100%; background: var(--success); color: white; border: none; padding: 14px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-size: 1rem;">
                        Terima Pesanan
                    </button>
                </form>
            @elseif($order->payment_status == 'completed')
                <div style="background: var(--success); color: white; padding: 14px; border-radius: 8px; text-align: center; font-weight: 600;">
                    Pesanan Selesai
                </div>
            @elseif($order->payment_status == 'cancelled')
                <div style="background: var(--danger); color: white; padding: 14px; border-radius: 8px; text-align: center; font-weight: 600;">
                    Pesanan Dibatalkan
                </div>
            @endif

            <a href="{{ route('buyer.orders.index') }}" 
               style="display: block; width: 100%; text-align: center; padding: 12px; background: white; color: var(--gray-700); border: 2px solid var(--accent-light); border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s;">
                Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>
</div>

<style>
button:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}

a:hover {
    background: var(--accent-lightest) !important;
    border-color: var(--accent);
}

@media (max-width: 768px) {
    div[style*="display: flex"] {
        flex-direction: column;
        align-items: stretch !important;
    }
}
</style>
@endsection