@extends('layouts.buyer')

@section('title', 'Pesanan Saya - ELSHOP')

@section('content')
<div class="section">
    <div class="section-header">
        <h2 class="section-title">Pesanan Saya</h2>
    </div>

    @if(isset($orders) && $orders->count() > 0)
        <div style="max-width: 900px; margin: 0 auto;">
            @foreach($orders as $order)
                <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 16px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
                    
                    <!-- Order Header -->
                    <div style="padding-bottom: 16px; margin-bottom: 16px; border-bottom: 2px solid var(--accent-light);">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 12px;">
                            <span style="font-weight: 700; color: var(--primary); font-size: 1.125rem;">
                                Order #{{ $order->code }}
                            </span>
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
                            <span style="background: {{ $status['color'] }}22; color: {{ $status['color'] }}; padding: 6px 16px; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                                {{ $status['text'] }}
                            </span>
                        </div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <!-- Order Items -->
                    @if($order->transactionDetails && $order->transactionDetails->count() > 0)
                        @foreach($order->transactionDetails as $item)
                            <div style="display: flex; gap: 16px; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--accent-lightest);">
                                @if($item->product && $item->product->images && $item->product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" 
                                         alt="{{ $item->product->name }}"
                                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
                                @else
                                    <div style="width: 80px; height: 80px; background: var(--gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--gray-400); flex-shrink: 0;">
                                        ?
                                    </div>
                                @endif
                                
                                <div style="flex: 1; min-width: 0;">
                                    <h4 style="font-weight: 600; margin-bottom: 8px;">
                                        <a href="{{ route('buyer.products.show', $item->product->id) }}" style="color: var(--gray-800); text-decoration: none;">
                                            {{ $item->product->name ?? 'Produk' }}
                                        </a>
                                    </h4>
                                    <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 8px;">
                                        {{ $item->qty }}x Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}
                                    </p>
                                    <div style="font-weight: 700; color: var(--primary);">
                                        Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p style="color: var(--gray-500); text-align: center; padding: 20px;">Tidak ada item</p>
                    @endif

                    <!-- Order Footer -->
                    <div style="margin-top: 16px; padding-top: 16px; border-top: 2px solid var(--accent-light);">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 16px;">
                            <div>
                                <span style="color: var(--gray-600); font-size: 0.938rem;">Total Pembayaran: </span>
                                <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
                                    Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        
                        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                            @if($order->payment_status == 'unpaid')
                                <form action="{{ route('buyer.orders.payment', $order->id) }}" method="POST" style="flex: 1; min-width: 120px;">
                                    @csrf
                                    <button type="submit" 
                                            style="width: 100%; background: var(--accent); color: white; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                                        Bayar Sekarang
                                    </button>
                                </form>
                                <form action="{{ route('buyer.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?')" style="flex: 1; min-width: 120px;">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" 
                                            style="width: 100%; background: white; color: var(--danger); border: 2px solid var(--danger); padding: 12px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                                        Batalkan
                                    </button>
                                </form>
                            @elseif($order->payment_status == 'shipped')
                                <form action="{{ route('buyer.orders.confirm', $order->id) }}" method="POST" style="flex: 1; min-width: 120px;">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" 
                                            style="width: 100%; background: var(--success); color: white; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                                        Terima Pesanan
                                    </button>
                                </form>
                            @elseif($order->payment_status == 'completed')
                                <a href="{{ route('buyer.review.create', $order->id) }}" 
                                   style="flex: 1; min-width: 120px; background: var(--warning); color: white; padding: 12px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                    ★ Rating & Review
                                </a>
                            @endif
                            
                            <a href="{{ route('buyer.orders.show', $order->id) }}" 
                               style="flex: 1; min-width: 120px; background: white; color: var(--accent); border: 2px solid var(--accent-light); padding: 12px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.2s; display: flex; align-items: center; justify-content: center;">
                                Detail Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <div style="margin-top: 24px;">
                {{ $orders->links() }}
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon" style="font-size: 5rem; margin-bottom: 20px;">
                <i class="fas fa-box-open"></i>
            </div>
            <h3 class="empty-title">Belum Ada Pesanan</h3>
            <p class="empty-text">Anda belum memiliki pesanan. Mulai belanja sekarang!</p>
            <a href="{{ route('buyer.products.index') }}" 
               style="display: inline-block; background: var(--accent); color: white; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 16px; box-shadow: var(--shadow-md); transition: all 0.2s;">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>

<style>
button:hover,
a[href*="orders.show"]:hover,
a[href*="products"]:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

a[href*="review.create"]:hover {
    background: #d97706 !important;
    transform: translateY(-2px);
}

button[type="submit"]:hover {
    opacity: 0.9;
}

a:hover {
    text-decoration: none;
}

@media (max-width: 768px) {
    div[style*="display: flex"] {
        flex-direction: column;
        align-items: stretch !important;
    }
    
    div[style*="flex: 1"] {
        flex: none !important;
        min-width: 0 !important;
    }

    form[style*="flex: 1"],
    a[style*="flex: 1"] {
        width: 100%;
    }
}
</style>
@endsection