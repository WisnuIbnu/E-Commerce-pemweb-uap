@extends('layouts.buyer')

@section('title', 'Pesanan Saya - ELSHOP')

@section('content')
<div class="section">
    <div class="section-header">
        <h2 class="section-title">📦 Pesanan Saya</h2>
    </div>

    {{-- Orders List --}}
    @if(isset($orders) && $orders->count() > 0)
        @foreach($orders as $order)
            <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 16px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                {{-- Order Header --}}
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; margin-bottom: 16px; border-bottom: 1px solid var(--accent-light);">
                    <div>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                            <span style="font-weight: 700; color: var(--primary);">
                                🛍️ Order #{{ $order->code }}
                            </span>
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
                            <span style="background: {{ $status['color'] }}22; color: {{ $status['color'] }}; padding: 4px 12px; border-radius: 20px; font-size: 0.813rem; font-weight: 600;">
                                <i class="fas fa-{{ $status['icon'] }}"></i> {{ $status['text'] }}
                            </span>
                        </div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">
                            📅 {{ $order->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                    <a href="{{ route('buyer.orders.show', $order->id) }}" 
                       style="color: var(--accent); text-decoration: none; font-weight: 600; transition: color 0.2s; display: flex; align-items: center; gap: 4px;">
                        Lihat Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                {{-- Order Items --}}
                @if($order->transactionDetails && $order->transactionDetails->count() > 0)
                    @foreach($order->transactionDetails as $item)
                        <div style="display: flex; gap: 16px; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--accent-lightest);">
                            @if($item->product && $item->product->images && $item->product->images->count() > 0)
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" 
                                     alt="{{ $item->product->name }}"
                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div style="width: 80px; height: 80px; background: var(--gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                    📦
                                </div>
                            @endif
                            
                            <div style="flex: 1;">
                                <h4 style="font-weight: 600; margin-bottom: 4px;">
                                    <a href="{{ route('buyer.products.show', $item->product->id) }}" style="color: var(--gray-800); text-decoration: none;">
                                        {{ $item->product->name ?? 'Produk' }}
                                    </a>
                                </h4>
                                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 8px;">
                                    {{ $item->qty }}x Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            <div style="text-align: right;">
                                <div style="font-weight: 700; color: var(--primary);">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="color: var(--gray-500); text-align: center; padding: 20px;">Tidak ada item</p>
                @endif

                {{-- Order Footer --}}
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--accent-light);">
                    <div>
                        <span style="color: var(--gray-600);">Total Pembayaran: </span>
                        <span style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    <div style="display: flex; gap: 12px;">
                        @if($order->payment_status == 'unpaid')
                            <form action="{{ route('buyer.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?')" style="display: inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" 
                                        style="background: white; color: var(--danger); border: 2px solid var(--danger); padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                                    ❌ Batalkan
                                </button>
                            </form>
                            <a href="#" 
                               style="background: var(--accent); color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.2s; display: inline-block;">
                                💳 Bayar Sekarang
                            </a>
                        @elseif($order->payment_status == 'shipped')
                            <form action="{{ route('buyer.orders.confirm', $order->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" 
                                        style="background: var(--success); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                                    ✅ Terima Pesanan
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('buyer.orders.show', $order->id) }}" 
                           style="background: white; color: var(--accent); border: 2px solid var(--accent-light); padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.2s; display: inline-block;">
                            👁️ Detail
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Pagination --}}
        <div style="margin-top: 24px;">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h3 class="empty-title">Belum Ada Pesanan</h3>
            <p class="empty-text">Anda belum memiliki pesanan. Mulai belanja sekarang!</p>
            <a href="{{ route('buyer.products.index') }}" 
               style="display: inline-block; background: var(--accent); color: white; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 16px; box-shadow: var(--shadow-md); transition: all 0.2s;">
                🛍️ Mulai Belanja
            </a>
        </div>
    @endif
</div>

<style>
button:hover,
a[href*="orders.show"]:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

button[type="submit"]:hover {
    opacity: 0.9;
}

a:hover {
    text-decoration: none;
}
</style>
@endsection