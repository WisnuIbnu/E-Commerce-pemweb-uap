@extends('layouts.app')

@section('title', 'Seller Dashboard - SORAE')

@section('content')
<h2 style="color: var(--primary-color); font-weight: 700; margin-bottom: 30px;">
    <i class="fas fa-store"></i> {{ $store->name }} Dashboard
</h2>

@if(!$store->is_verified)
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle"></i> 
    Your store is pending verification. Please wait for admin approval.
</div>
@endif

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-box fa-3x mb-3" style="color: var(--primary-color);"></i>
                <h3 style="color: var(--primary-color);">{{ $totalProducts }}</h3>
                <p class="text-muted mb-0">Total Products</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-shopping-cart fa-3x mb-3" style="color: #28a745;"></i>
                <h3 style="color: #28a745;">{{ $totalOrders }}</h3>
                <p class="text-muted mb-0">Total Orders</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-clock fa-3x mb-3" style="color: #ffc107;"></i>
                <h3 style="color: #ffc107;">{{ $pendingOrders }}</h3>
                <p class="text-muted mb-0">Pending Orders</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-wallet fa-3x mb-3" style="color: #17a2b8;"></i>
                <h3 style="color: #17a2b8;">Rp {{ number_format($balance, 0, ',', '.') }}</h3>
                <p class="text-muted mb-0">Balance</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <a href="{{ url('/seller/products/create') }}" class="card text-decoration-none">
            <div class="card-body text-center">
                <i class="fas fa-plus-circle fa-3x mb-3" style="color: var(--primary-color);"></i>
                <h5>Add New Product</h5>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ url('/seller/orders') }}" class="card text-decoration-none">
            <div class="card-body text-center">
                <i class="fas fa-list-alt fa-3x mb-3" style="color: var(--primary-color);"></i>
                <h5>Manage Orders</h5>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ url('/seller/balance') }}" class="card text-decoration-none">
            <div class="card-body text-center">
                <i class="fas fa-money-bill-wave fa-3x mb-3" style="color: var(--primary-color);"></i>
                <h5>View Balance</h5>
            </div>
        </a>
    </div>
</div>

<!-- Recent Orders -->
<div class="card mb-4">
    <div class="card-header">
        <h4 class="mb-0">Recent Orders</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td><strong>{{ $order->code }}</strong></td>
                        <td>{{ $order->buyer->user->name }}</td>
                        <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $order->payment_status === 'pending' ? 'warning' : 'success' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ url('/seller/orders/' . $order->id) }}" class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No orders yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection