@extends('layouts.admin')

@section('title', 'Admin Dashboard - FlexSport')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush

@section('content')
<div class="content">
    <div class="page-header">
        <h1>⚙️ Admin Dashboard</h1>
        <p>Selamat datang, <strong>Admin</strong>!</p>
    </div>

    @if($stats['pending_stores'] > 0)
    <div class="alert alert-warning">
        ⚠️ Ada <strong>{{ $stats['pending_stores'] }}</strong> toko yang menunggu verifikasi!
        <a href="{{ route('admin.stores') }}">Lihat Sekarang →</a>
    </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-icon">👥</span>
            <span class="stat-value">{{ $stats['total_users'] }}</span>
            <span class="stat-label">Total Users</span>
        </div>
        
        <div class="stat-card">
            <span class="stat-icon">🏪</span>
            <span class="stat-value">{{ $stats['total_stores'] }}</span>
            <span class="stat-label">Toko Aktif</span>
        </div>
        
        <div class="stat-card">
            <span class="stat-icon">⏳</span>
            <span class="stat-value">{{ $stats['pending_stores'] }}</span>
            <span class="stat-label">Toko Pending</span>
        </div>
        
        <div class="stat-card">
            <span class="stat-icon">📦</span>
            <span class="stat-value">{{ $stats['total_products'] }}</span>
            <span class="stat-label">Total Produk</span>
        </div>
        
        <div class="stat-card">
            <span class="stat-icon">💰</span>
            <span class="stat-value">{{ $stats['total_transactions'] }}</span>
            <span class="stat-label">Transaksi</span>
        </div>
    </div>
</div>
@endsection