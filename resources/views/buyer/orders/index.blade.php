@extends('layouts.buyer')

@section('title', 'Pesanan Saya - ELSHOP')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('buyer.dashboard') }}">Beranda</a>
    <span>/</span>
    <span>Pesanan Saya</span>
</div>

<div class="section">
    <div class="section-header">
        <h2 class="section-title">📦 Pesanan Saya</h2>
    </div>

    {{-- Filter Tabs --}}
    <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 24px; box-shadow: var(--shadow); border: 1px solid var(--accent-light);">
        <div style="display: flex; gap: 16px; overflow-x: auto;">
            <a href="{{ route('buyer.orders.index') }}" 
               class="filter-tab {{ !request('status') ? 'active' : '' }}"
               style="padding: 10px 20px; border-radius: 8px; text-decoration: none; white-space: nowrap; font-weight: 600; transition: all 0.2s;">
                Semua
            </a>
            <a href="{{ route('buyer.orders.index', ['status' => 'pending']) }}" 
               class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}"
               style="padding: 10px 20px; border-radius: 8px; text-decoration: none; white-space: nowrap; font-weight: 600; transition: all 0.2s;">
                Menunggu Pembayaran
            </a>
            <a href="{{ route('buyer.orders.index', ['status' => 'processing']) }}" 
               class="filter-tab {{ request('status') == 'processing' ? 'active' : '' }}"
               style="padding: 10px 20px; border-radius: 8px; text-decoration: none; white-space: nowrap; font-weight: 600; transition: all 0.2s;">
                Diproses
            </a>
            <a href="{{ route('buyer.orders.index', ['status' => 'shipped']) }}" 
               class="filter-tab {{ request('status') == 'shipped' ? 'active' : '' }}"
               style="padding: 10px 20px; border-radius: 8px; text-decoration: none; white-space: nowrap; font-weight: 600; transition: all 0.2s;">
                Dikirim
            </a>
            <a href="{{ route('buyer.orders.index', ['status' => 'completed']) }}" 
               class="filter-tab {{ request('status') == 'completed' ? 'active' : '' }}"
               style="padding: 10px 20px; border-radius: 8px; text-decoration: none; white-space: nowrap; font-weight: 600; transition: all 0.2s;">
                Selesai
            </a>
            <a href="{{ route('buyer.orders.index', ['status' => 'cancelled']) }}" 
               class="filter-tab {{ request('status') == 'cancelled' ? 'active' : '' }}"
               style="padding: 10px 20px; border-radius: 8px; text-decoration: none; white-space: nowrap; font-weight: 600; transition: all 0.2s;">
                Dibatalkan
            </a>
        </div>
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
                                <i class="fas fa-shopping-bag"></i> Order #{{ $order->id }}
                            </span>
                            @php
                                $statusConfig = [
                                    'pending' => ['color' => 'var(--warning)', 'text' => 'Menunggu Pembayaran', 'icon' => 'clock'],
                                    'processing' => ['color' => 'var(--accent)', 'text' => 'Diproses', 'icon' => 'cog'],
                                    'shipped' => ['color' => 'var(--accent)', 'text' => 'Dikirim', 'icon' => 'truck'],
                                    'completed' => ['color' => 'var(--success)', 'text' => 'Selesai', 'icon' => 'check-circle'],
                                    'cancelled' => ['color' => 'var(--danger)', 'text' => 'Dibatalkan', 'icon' => 'times-circle']
                                ];
                                $status = $statusConfig[$order->status] ?? $statusConfig['pending'];
                            @endphp
                            <span style="background: {{ $status['color'] }}22; color: {{ $status['color'] }}; padding: 4px 12px; border-radius: 20px; font-size: 0.813rem; font-weight: 600;">
                                <i class="fas fa-{{ $status['icon'] }}"></i> {{ $status['text'] }}
                            </span>
                        </div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">
                            <i class="fas fa-calendar"></i> {{ $order->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                    <a href="{{ route('buyer.orders.show', $order->id) }}" 
                       style="color: var(--accent); text-decoration: none; font-weight: 600; transition: color 0.2s;">
                        Lihat Detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                {{-- Order Items --}}
                @if($order->items)
                    @foreach($order->items as $item)
                        <div style="display: flex; gap: 16px; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--accent-lightest);">
                            @if($item->product && $item->product->images && $item->product->images->count() > 0)
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_url) }}" 
                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div style="width: 80px; height: 80px; background: var(--gray-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                    📦
                                </div>
                            @endif
                            
                            <div style="flex: 1;">
                                <h4 style="font-weight: 600; margin-bottom: 4px;">
                                    {{ $item->product_name ?? 'Product' }}
                                </h4>
                                <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 8px;">
                                    {{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            <div style="text-align: right;">
                                <div style="font-weight: 700; color: var(--primary);">
                                    Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- Order Footer --}}
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--accent-light);">
                    <div>
                        <span style="color: var(--gray-600);">Total Pembayaran: </span>
                        <span style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    <div style="display: flex; gap: 12px;">
                        @if($order->status == 'pending')
                            <form action="{{ route('buyer.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?')">
                                @csrf
                                <button type="submit" 
                                        style="background: white; color: var(--danger); border: 2px solid var(--danger); padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                                    <i class="fas fa-times"></i> Batalkan
                                </button>
                            </form>
                            <a href="#" 
                               style="background: var(--accent); color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.2s; display: inline-block;">
                                <i class="fas fa-credit-card"></i> Bayar Sekarang
                            </a>
                        @elseif($order->status == 'shipped')
                            <form action="{{ route('buyer.orders.confirm', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        style="background: var(--success); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                                    <i class="fas fa-check"></i> Terima Pesanan
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('buyer.orders.show', $order->id) }}" 
                           style="background: white; color: var(--accent); border: 2px solid var(--accent-light); padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.2s; display: inline-block;">
                            <i class="fas fa-eye"></i> Detail
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
                <i class="fas fa-shopping-bag"></i> Mulai Belanja
            </a>
        </div>
    @endif
</div>

<style>
.filter-tab {
    color: var(--gray-700);
    background: var(--gray-100);
}

.filter-tab:hover {
    background: var(--accent-lightest);
    color: var(--primary);
}

.filter-tab.active {
    background: var(--accent);
    color: white;
}

button:hover,
a[href*="orders.show"]:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

button[type="submit"]:has(i.fa-times):hover {
    background: var(--danger) !important;
    color: white !important;
}

button[type="submit"]:has(i.fa-check):hover {
    transform: scale(1.05);
}

a[href*="credit-card"]:hover {
    background: var(--primary) !important;
}
</style>
@endsection