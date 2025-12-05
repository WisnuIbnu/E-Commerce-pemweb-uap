@extends('layouts.app')

@vite(['resources/css/dashboard.css'])

@section('content')
<div class="dashboard-container admin-dashboard">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p>Kelola platform ElSHOP</p>
    </div>

    <div class="dashboard-grid">
        <!-- Quick Stats -->
        <div class="stats-section">
            <div class="stat-card highlight">
                <div class="stat-icon">👥</div>
                <div class="stat-content">
                    <h3>Total User</h3>
                    <p class="stat-number">1,245</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🏪</div>
                <div class="stat-content">
                    <h3>Total Toko</h3>
                    <p class="stat-number">384</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📦</div>
                <div class="stat-content">
                    <h3>Total Produk</h3>
                    <p class="stat-number">9,521</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">💵</div>
                <div class="stat-content">
                    <h3>GMV Bulan Ini</h3>
                    <p class="stat-number">Rp2.3B</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="actions-section">
            <h2>Manajemen Platform</h2>
            <div class="action-buttons">
                <a href="{{ route('admin.stores.index') }}" class="action-btn">
                    <span class="icon">✓</span>
                    <span>Approval Toko</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="action-btn">
                    <span class="icon">👥</span>
                    <span>Kelola User</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="action-btn">
                    <span class="icon">📁</span>
                    <span>Kelola Produk</span>
                </a>
                <a href="#" class="action-btn">
                    <span class="icon">📊</span>
                    <span>Laporan</span>
                </a>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="recent-orders-section">
            <h2>Approval Menunggu</h2>
            <div class="orders-list">
                <p style="text-align: center; color: #999; padding: 20px;">Tidak ada pending approval</p>
            </div>
        </div>
    </div>
</div>
@endsection