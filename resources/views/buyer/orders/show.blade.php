@extends('layouts.buyer')

@section('title', 'Detail Pesanan - ELSHOP')

@section('content')
<div class="section">
    {{-- Breadcrumb --}}
    <div style="margin-bottom: 24px; font-size: 0.938rem;">
        <a href="{{ route('buyer.dashboard') }}" style="color: var(--accent); text-decoration: none;">Beranda</a>
        <span> / </span>
        <a href="{{ route('buyer.orders.index') }}" style="color: var(--accent); text-decoration: none;">Pesanan Saya</a>
        <span> / </span>
        <span style="color: var(--gray-600);">Detail Pesanan</span>
    </div>

    {{-- Order Header --}}
    <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
            <div>
                <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--gray-900); margin-bottom: 8px;">
                    🛍️ {{ $order->code }}
                </h1>
                <p style="color: var(--gray-600); font-size: 0.938rem;">
                    📅 {{ $order->created_at->format('d M Y, H:i') }}
                </p>
            </div>

            @php
                $statusConfig = [
                    'unpaid' => ['color' => 'var(--warning)', 'text' => 'Menunggu Pembayaran', 'icon' => 'clock'],
                    'paid' => ['color' => 'var(--accent)', 'text' => 'Diproses', 'icon' => 'cog'],
                    'shipped' => ['color' => 'var(--info)', 'text' => 'Dikirim', 'icon' => 'truck'],
                    'completed' => ['color' => 'var(--success)', 'text' => 'Selesai', 'icon' => 'check-circle'],
                    'cancelled' => ['color' => 'var(--danger)', 'text' => 'Dibatalkan', 'icon' => 'times-circle']
                ];
                $status = $statusConfig[$order->payment_status] ?? $statusConfig['unpaid'];
            @endphp
            <span style="background: {{ $status['color'] }}22; color: {{ $status['color'] }}; padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                <i class="fas fa-{{ $status['icon'] }}"></i> {{ $status['text'] }}
            </span>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 24px;">
        {{-- Left Column: Items --}}
        <div>
            {{-- Order Items --}}
            <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 20px;">
                    📦 Detail Produk
                </h3>

                @if($order->transactionDetails && $order->transactionDetails->count() > 0)
                    @foreach($order->transactionDetails as $item)
                        <div style="display: flex; gap: 16px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid var(--accent-light);">
                            @if($item->product && $item->product->images && $item->product->images->count() > 0)
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" 
                                     alt="{{ $item->product->name }}"
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div style="width: 100px; height: 100px; background: var(--gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                    📦
                                </div>
                            @endif
                            
                            <div style="flex: 1;">
                                <h4 style="font-weight: 600; margin-bottom: 8px;">
                                    <a href="{{ route('buyer.products.show', $item->product->id) }}" style="color: var(--gray-800); text-decoration: none;">
                                        {{ $item->product->name ?? 'Produk' }}
                                    </a>
                                </h4>
                                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 12px;">
                                    SKU: {{ $item->product->sku ?? '-' }}
                                </p>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: var(--gray-600);">
                                        {{ $item->qty }}x Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}
                                    </span>
                                    <span style="font-weight: 700; color: var(--primary);">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
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

            {{-- Shipping Info --}}
            <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                    🚚 Informasi Pengiriman
                </h3>

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <label style="color: var(--gray-600); font-size: 0.875rem; font-weight: 600;">Alamat Pengiriman</label>
                        <p style="color: var(--gray-800); margin-top: 4px;">{{ $order->address }}</p>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="color: var(--gray-600); font-size: 0.875rem; font-weight: 600;">Kota</label>
                            <p style="color: var(--gray-800); margin-top: 4px;">{{ $order->city }}</p>
                        </div>
                        <div>
                            <label style="color: var(--gray-600); font-size: 0.875rem; font-weight: 600;">Kode Pos</label>
                            <p style="color: var(--gray-800); margin-top: 4px;">{{ $order->postal_code }}</p>
                        </div>
                    </div>

                    <div>
                        <label style="color: var(--gray-600); font-size: 0.875rem; font-weight: 600;">Metode Pengiriman</label>
                        <p style="color: var(--gray-800); margin-top: 4px; text-transform: capitalize;">
                            {{ $order->shipping_type }} - Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                        </p>
                    </div>

                    @if($order->tracking_number)
                    <div>
                        <label style="color: var(--gray-600); font-size: 0.875rem; font-weight: 600;">Nomor Resi</label>
                        <p style="color: var(--gray-800); margin-top: 4px; font-family: monospace; font-weight: 600;">
                            {{ $order->tracking_number }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column: Summary --}}
        <div>
            {{-- Order Summary --}}
            <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light); position: sticky; top: 160px;">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900); margin-bottom: 20px;">
                    💰 Ringkasan Pesanan
                </h3>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    {{-- Subtotal --}}
                    <div style="display: flex; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid var(--accent-light);">
                        <span style="color: var(--gray-600);">Subtotal</span>
                        <span style="font-weight: 600;">Rp {{ number_format($order->grand_total - $order->shipping_cost - $order->tax, 0, ',', '.') }}</span>
                    </div>

                    {{-- Shipping --}}
                    <div style="display: flex; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid var(--accent-light);">
                        <span style="color: var(--gray-600);">Ongkos Kirim</span>
                        <span style="font-weight: 600;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>

                    {{-- Tax --}}
                    <div style="display: flex; justify-content: space-between; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 2px solid var(--accent-light);">
                        <span style="color: var(--gray-600);">Pajak</span>
                        <span style="font-weight: 600;">Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                    </div>

                    {{-- Total --}}
                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                        <span style="font-size: 1.125rem; font-weight: 700; color: var(--gray-900);">Total</span>
                        <span style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Actions --}}
                    @if($order->payment_status == 'unpaid')
                        <form id="payment-form" action="{{ route('buyer.orders.payment', $order->id) }}" method="POST" style="margin-bottom: 8px;">
                            @csrf
                            <button type="button" onclick="document.getElementById('payment-form').submit();" style="width: 100%; background: var(--accent); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-size: 1rem;">
                                💳 Bayar Sekarang
                            </button>
                        </form>
                        
                        <form id="cancel-form" action="{{ route('buyer.orders.cancel', $order->id) }}" method="POST">
                            @csrf
                            <button type="button" onclick="if(confirm('Batalkan pesanan ini?')) { document.getElementById('cancel-form').submit(); }" style="width: 100%; background: white; color: var(--danger); border: 2px solid var(--danger); padding: 10px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-size: 1rem;">
                                ❌ Batalkan Pesanan
                            </button>
                        </form>
                    @elseif($order->payment_status == 'paid')
                        <div style="background: var(--success); color: white; padding: 12px; border-radius: 8px; text-align: center; font-weight: 600;">
                            ✅ Pembayaran Diterima - Sedang Diproses
                        </div>
                    @elseif($order->payment_status == 'shipped')
                        <form id="confirm-form" action="{{ route('buyer.orders.confirm', $order->id) }}" method="POST">
                            @csrf
                            <button type="button" onclick="document.getElementById('confirm-form').submit();" style="width: 100%; background: var(--success); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-size: 1rem;">
                                ✅ Terima Pesanan
                            </button>
                        </form>
                    @elseif($order->payment_status == 'completed')
                        <div style="background: var(--success); color: white; padding: 12px; border-radius: 8px; text-align: center; font-weight: 600;">
                            ✅ Pesanan Selesai
                        </div>
                    @elseif($order->payment_status == 'cancelled')
                        <div style="background: var(--danger); color: white; padding: 12px; border-radius: 8px; text-align: center; font-weight: 600;">
                            ❌ Pesanan Dibatalkan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr 350px"] {
        grid-template-columns: 1fr !important;
    }
}

a:hover {
    text-decoration: underline;
}
</style>
@endsection