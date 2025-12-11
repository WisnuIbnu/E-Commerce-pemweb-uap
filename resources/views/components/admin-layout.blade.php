<x-admin-layout>
    <x-slot name="title">Admin Dashboard - SORAÉ</x-slot>
    
    <style>
        .dashboard-header {
            margin-bottom: 40px;
        }
        
        .dashboard-header h1 {
            font-size: 2.5rem;
            color: var(--color-primary);
            margin-bottom: 10px;
        }
        
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: var(--color-white);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .stat-label {
            color: var(--color-tertiary);
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-primary);
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        .dashboard-section {
            background: var(--color-white);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .section-header h2 {
            font-size: 1.5rem;
            color: var(--color-primary);
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table thead {
            background: var(--color-light);
        }
        
        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--color-light);
        }
        
        .table th {
            color: var(--color-primary);
            font-weight: 600;
        }
        
        .table tbody tr:hover {
            background: #fafafa;
        }
        
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        .quick-actions {
            display: grid;
            gap: 15px;
        }
        
        .action-btn {
            padding: 15px;
            background: var(--color-light);
            border: none;
            border-radius: 10px;
            text-align: left;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        
        .action-btn:hover {
            background: var(--color-tertiary);
            transform: translateX(5px);
        }
        
        .action-btn-title {
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 5px;
        }
        
        .action-btn-desc {
            font-size: 0.9rem;
            color: var(--color-secondary);
        }
        
        @media (max-width: 968px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <p style="color: var(--color-secondary);">Welcome back! Here's what's happening with your store.</p>
    </div>
    
    <!-- Statistics Cards -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ $totalUsers ?? 0 }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🏪</div>
            <div class="stat-label">Active Stores</div>
            <div class="stat-value">{{ $totalStores ?? 0 }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ $totalProducts ?? 0 }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>
    
    <!-- Dashboard Grid -->
    <div class="dashboard-grid">
        <!-- Recent Users -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2>Recent Users</h2>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">View All</a>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers ?? [] as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <span class="badge badge-success">Active</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: var(--color-tertiary);">
                            No users found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Quick Actions -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2>Quick Actions</h2>
            </div>
            
            <div class="quick-actions">
                <a href="{{ route('admin.users.index') }}" class="action-btn">
                    <div class="action-btn-title">👥 Manage Users</div>
                    <div class="action-btn-desc">View and manage all users</div>
                </a>
                
                <a href="{{ route('admin.stores.index') }}" class="action-btn">
                    <div class="action-btn-title">🏪 Manage Stores</div>
                    <div class="action-btn-desc">View and manage all stores</div>
                </a>
                
                <a href="{{ route('products.index') }}" class="action-btn">
                    <div class="action-btn-title">📦 View Products</div>
                    <div class="action-btn-desc">Browse all products</div>
                </a>
                
                <a href="#" class="action-btn">
                    <div class="action-btn-title">📊 Reports</div>
                    <div class="action-btn-desc">Generate sales reports</div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Recent Stores -->
    <div class="dashboard-section" style="margin-top: 30px;">
        <div class="section-header">
            <h2>Recent Stores</h2>
            <a href="{{ route('admin.stores.index') }}" class="btn btn-secondary">View All</a>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Store Name</th>
                    <th>Owner</th>
                    <th>Products</th>
                    <th>Created</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentStores ?? [] as $store)
                <tr>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->buyer->name ?? 'N/A' }}</td>
                    <td>{{ $store->products_count ?? 0 }}</td>
                    <td>{{ $store->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="badge badge-success">Active</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 30px; color: var(--color-tertiary);">
                        No stores found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>

<!-- UPDATE resources/views/components/admin-layout.blade.php -->
<!-- ADD THIS TO THE SIDEBAR MENU AFTER STORES MENU -->

<li class="menu-item">
    <a href="{{ route('admin.stores.index') }}" class="menu-link {{ request()->routeIs('admin.stores.index') ? 'active' : '' }}">
        <span class="menu-icon">🏪</span>
        <span>All Stores</span>
    </a>
</li>

<li class="menu-item">
    <a href="{{ route('admin.stores.pending') }}" class="menu-link {{ request()->routeIs('admin.stores.pending') || request()->routeIs('admin.stores.verify') ? 'active' : '' }}">
        <span class="menu-icon">⏳</span>
        <span>Pending Stores</span>
        @php
            $pendingCount = \App\Models\Store::where('status', 'pending')->count();
        @endphp
        @if($pendingCount > 0)
            <span style="background: #dc3545; color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; margin-left: 10px;">
                {{ $pendingCount }}
            </span>
        @endif
    </a>
</li>

<li class="menu-item">
    <a href="{{ route('admin.categories.index') }}" class="menu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <span class="menu-icon">📂</span>
        <span>Categories</span>
    </a>
</li>

<li class="menu-item">
    <a href="{{ route('admin.withdrawals.index') }}" class="menu-link {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}">
        <span class="menu-icon">💳</span>
        <span>Withdrawals</span>
        @php
            $pendingWithdrawals = \App\Models\Withdrawal::where('status', 'pending')->count();
        @endphp
        @if($pendingWithdrawals > 0)
            <span style="background: #ffc107; color: #856404; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; margin-left: 10px;">
                {{ $pendingWithdrawals }}
            </span>
        @endif
    </a>
</li>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Dashboard - SORAÉ' }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-primary: #561C24;
            --color-secondary: #6D2932;
            --color-tertiary: #C7B7A3;
            --color-light: #E8D8C4;
            --color-white: #FFFFFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            color: var(--color-primary);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        
        .admin-container {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: var(--color-white);
            padding: 30px 0;
            position: fixed;
            width: 260px;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar-logo {
            padding: 0 30px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 30px;
        }
        
        .sidebar-logo img {
            max-width: 120px;
            filter: brightness(0) invert(1);
        }
        
        .sidebar-logo h2 {
            color: var(--color-white);
            margin-top: 10px;
            font-size: 1.3rem;
        }
        
        .sidebar-menu {
            list-style: none;
        }
        
        .menu-item {
            margin-bottom: 5px;
        }
        
        .menu-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 30px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .menu-link:hover,
        .menu-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: var(--color-white);
        }
        
        .menu-icon {
            font-size: 20px;
            width: 24px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 40px;
        }
        
        .topbar {
            background: var(--color-white);
            padding: 20px 30px;
            margin: -40px -40px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .topbar-left h1 {
            font-size: 1.8rem;
            color: var(--color-primary);
        }
        
        .topbar-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px 20px;
            background: var(--color-light);
            border-radius: 25px;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-white);
            font-weight: 600;
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            font-weight: 600;
            color: var(--color-primary);
        }
        
        .user-role {
            font-size: 0.85rem;
            color: var(--color-tertiary);
        }
        
        /* Button Styles */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background-color: var(--color-primary);
            color: var(--color-white);
        }
        
        .btn-primary:hover {
            background-color: var(--color-secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(86, 28, 36, 0.3);
        }
        
        .btn-secondary {
            background-color: transparent;
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
        }
        
        .btn-secondary:hover {
            background-color: var(--color-primary);
            color: var(--color-white);
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: var(--color-white);
        }
        
        .btn-danger:hover {
            background-color: #c82333;
        }
        
        @media (max-width: 968px) {
            .admin-container {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <img src="{{ asset('images/soraelogo.png') }}" alt="SORAÉ">
                <h2>Admin Panel</h2>
            </div>
            
            <ul class="sidebar-menu">
                <li class="menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="menu-icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.users.index') }}" class="menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span class="menu-icon">👥</span>
                        <span>Users</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.stores.index') }}" class="menu-link {{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
                        <span class="menu-icon">🏪</span>
                        <span>Stores</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('products.index') }}" class="menu-link">
                        <span class="menu-icon">📦</span>
                        <span>Products</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <span class="menu-icon">💰</span>
                        <span>Transactions</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <span class="menu-icon">⭐</span>
                        <span>Reviews</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <span class="menu-icon">⚙️</span>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="menu-item" style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                    <a href="{{ route('home') }}" class="menu-link">
                        <span class="menu-icon">🏠</span>
                        <span>Back to Website</span>
                    </a>
                </li>
            </ul>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="topbar">
                <div class="topbar-left">
                    <p style="color: var(--color-tertiary); margin-bottom: 5px;">Welcome back,</p>
                    <h1>{{ auth()->user()->name }}</h1>
                </div>
                
                <div class="topbar-right">
                    <div class="user-menu">
                        <div class="user-avatar">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <span class="user-role">Administrator</span>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Logout</button>
                    </form>
                </div>
            </div>
            
            {{ $slot }}
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>


