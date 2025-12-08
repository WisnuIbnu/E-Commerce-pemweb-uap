@extends('layouts.admin')

@section('title', 'Admin Dashboard - FlexSport')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush

@section('content')
<div class="content">
    <div class="page-header">
        <h1>ADMIN DASHBOARD</h1>
        <p>Welcome back, <strong>Admin</strong>. Here is your system overview.</p>
    </div>

    @if($stats['pending_stores'] > 0)
    <div class="alert alert-warning">
        ⚠️ There are <strong>{{ $stats['pending_stores'] }}</strong> stores pending verification.
        <a href="{{ route('admin.stores') }}" style="color:inherit; font-weight:bold; margin-left:10px;">Review Now →</a>
    </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-icon" style="display:none;">👥</span>
            <span class="stat-value">{{ $stats['total_users'] }}</span>
            <span class="stat-label">Total Users</span>
        </div>
        
        <div class="stat-card">
            <span class="stat-icon" style="display:none;">🏪</span>
            <span class="stat-value">{{ $stats['total_stores'] }}</span>
            <span class="stat-label">Active Stores</span>
        </div>
        
        <div class="stat-card">
            <span class="stat-icon" style="display:none;">⏳</span>
            <span class="stat-value">{{ $stats['pending_stores'] }}</span>
            <span class="stat-label">Pending Reviews</span>
        </div>
        
        <div class="stat-card">
            <span class="stat-icon" style="display:none;">📦</span>
            <span class="stat-value">{{ $stats['total_products'] }}</span>
            <span class="stat-label">Products Listed</span>
        </div>
        
        <div class="stat-card">
            <span class="stat-icon" style="display:none;">💰</span>
            <span class="stat-value">{{ $stats['total_transactions'] }}</span>
            <span class="stat-label">Total Orders</span>
        </div>
    </div>
</div>
@endsection