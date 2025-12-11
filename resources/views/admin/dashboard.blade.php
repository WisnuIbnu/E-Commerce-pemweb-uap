<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')
@section('title', 'Admin Dashboard - SORAE')
@section('content')
<h2 style="color: var(--primary-color);">Admin Dashboard</h2>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-users fa-3x mb-3" style="color: var(--primary-color);"></i>
                <h3>{{ $totalUsers }}</h3>
                <p class="mb-0">Total Users</p>
                <a href="{{ url('/admin/users') }}" class="btn btn-sm btn-primary mt-2">View All</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-store fa-3x mb-3" style="color: #28a745;"></i>
                <h3>{{ $totalStores }}</h3>
                <p class="mb-0">Total Stores</p>
                <a href="{{ url('/admin/stores') }}" class="btn btn-sm btn-success mt-2">View All</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-box fa-3x mb-3" style="color: #17a2b8;"></i>
                <h3>{{ $totalProducts }}</h3>
                <p class="mb-0">Total Products</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-shopping-cart fa-3x mb-3" style="color: #ffc107;"></i>
                <h3>{{ $totalTransactions }}</h3>
                <p class="mb-0">Transactions</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Recent Users</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td><span class="badge bg-primary">{{ $user->role }}</span></td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Pending Store Verification</h5>
            </div>
            <div class="card-body">
                <h3 class="text-center" style="color: var(--primary-color);">{{ $pendingStores }}</h3>
                <p class="text-center mb-0">Stores waiting for verification</p>
                <a href="{{ url('/admin/stores/verification') }}" class="btn btn-primary w-100 mt-3">
                    <i class="fas fa-check-circle"></i> Review Pending Stores
                </a>
            </div>
        </div>
    </div>
</div>
@endsection