@extends('layouts.seller')
@section('title','Dashboard')

@section('content')
{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="page-header-actions">
        <div>
            <h1>Seller Dashboard</h1>
            <p>Selamat datang kembali, {{ $store->name }}!</p>
        </div>
        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
            ➕ Tambah Produk
        </a>
    </div>
</div>

{{-- STATISTICS GRID --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total Produk</span>
            <div class="stat-icon primary">📦</div>
        </div>
        <div class="stat-value">{{ $stats['total_products'] }}</div>
        <div class="stat-description">Produk aktif</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-header">
            <span class="stat-label">Pesanan Pending</span>
            <div class="stat-icon warning">⏳</div>
        </div>
        <div class="stat-value">{{ $stats['pending_orders'] }}</div>
        <div class="stat-description">Perlu diproses</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total Pesanan</span>
            <div class="stat-icon primary">🛒</div>
        </div>
        <div class="stat-value">{{ $stats['total_orders'] }}</div>
        <div class="stat-description">Semua pesanan</div>
    </div>

    <div class="stat-card success">
        <div class="stat-header">
            <span class="stat-label">Total Pendapatan</span>
            <div class="stat-icon success">💰</div>
        </div>
        <div class="stat-value">{{ formatRupiah($stats['total_revenue']) }}</div>
        <div class="stat-description">Dari pesanan selesai</div>
    </div>
</div>

{{-- RECENT ORDERS --}}
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Pesanan Terbaru</h2>
        <a href="{{ route('seller.orders.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body">
        @if($recentOrders->count() > 0)
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pembeli</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ formatRupiah($order->total_amount) }}</td>
                            <td>
                                <span class="status-badge {{ getStatusBadgeClass($order->status) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('seller.orders.show', $order->id) }}" class="btn btn-secondary btn-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h3 class="empty-title">Belum ada pesanan</h3>
                <p class="empty-text">Pesanan akan muncul di sini setelah ada pembeli yang membeli produk Anda.</p>
            </div>
        @endif
    </div>
</div>
@endsection