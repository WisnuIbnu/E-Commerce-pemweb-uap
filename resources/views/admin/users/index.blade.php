@extends('layouts.app')

@section('title', 'Users Management - DrizStuff')

@push('styles')
<style>
.admin-layout {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: var(--spacing-xl);
    padding: var(--spacing-2xl) 0;
}

.admin-sidebar {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--spacing-lg);
    height: fit-content;
    position: sticky;
    top: 100px;
}

.admin-header {
    text-align: center;
    padding-bottom: var(--spacing-lg);
    border-bottom: 1px solid var(--border);
    margin-bottom: var(--spacing-lg);
}

.admin-badge {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--danger) 0%, #DC2626 100%);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    margin: 0 auto var(--spacing-md);
}

.admin-title {
    font-weight: 600;
    margin-bottom: var(--spacing-xs);
}

.admin-nav {
    list-style: none;
}

.admin-nav-item {
    margin-bottom: var(--spacing-xs);
}

.admin-nav-link {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: 10px 12px;
    border-radius: var(--radius-md);
    color: var(--dark);
    text-decoration: none;
    transition: all 0.2s;
    font-size: 14px;
}

.admin-nav-link:hover,
.admin-nav-link.active {
    background: var(--primary-light);
    color: var(--primary);
}

.users-content {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-lg);
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stats-mini {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: var(--spacing-md);
}

.stat-mini {
    background: var(--white);
    padding: var(--spacing-lg);
    border-radius: var(--radius-lg);
    text-align: center;
}

.stat-mini-value {
    font-size: 28px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: var(--spacing-xs);
}

.stat-mini-label {
    font-size: 14px;
    color: var(--gray);
}

.filters-bar {
    display: flex;
    gap: var(--spacing-sm);
    background: var(--white);
    padding: var(--spacing-md);
    border-radius: var(--radius-lg);
}

.filter-tab {
    padding: 8px 16px;
    border: 1px solid var(--border);
    background: var(--white);
    border-radius: var(--radius-full);
    cursor: pointer;
    transition: all 0.2s;
    font-size: 14px;
    text-decoration: none;
    color: var(--dark);
}

.filter-tab:hover,
.filter-tab.active {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
}

.search-box {
    flex: 1;
}

.search-input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 14px;
}

.users-table-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.table-wrapper {
    overflow-x: auto;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
}

.users-table thead {
    background: var(--light-gray);
}

.users-table th {
    padding: var(--spacing-md);
    text-align: left;
    font-weight: 600;
    font-size: 14px;
    border-bottom: 2px solid var(--border);
}

.users-table td {
    padding: var(--spacing-md);
    border-bottom: 1px solid var(--border);
}

.users-table tbody tr:hover {
    background: var(--light-gray);
}

.user-cell {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.user-info h4 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 2px;
}

.user-email {
    font-size: 12px;
    color: var(--gray);
}

.action-buttons {
    display: flex;
    gap: var(--spacing-xs);
}

.btn-icon {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-md);
    border: 1px solid var(--border);
    background: var(--white);
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    font-size: 14px;
}

.btn-icon:hover {
    background: var(--light-gray);
}

.empty-state {
    text-align: center;
    padding: var(--spacing-2xl);
    color: var(--gray);
}

@media (max-width: 768px) {
    .admin-layout {
        grid-template-columns: 1fr;
    }
    
    .admin-sidebar {
        position: static;
    }
    
    .stats-mini {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="admin-layout">
        <!-- Admin Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-header">
                <div class="admin-badge">🔧</div>
                <div class="admin-title">Admin Panel</div>
                <span class="badge badge-danger">Administrator</span>
            </div>

            <ul class="admin-nav">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="admin-nav-link">
                        📊 Dashboard
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.stores.index') }}" class="admin-nav-link">
                        🏪 Stores
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.users.index') }}" class="admin-nav-link active">
                        👥 Users
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.withdrawals.index') }}" class="admin-nav-link">
                        💳 Withdrawals
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="users-content">
            <div class="page-header">
                <h1>👥 Users Management</h1>
            </div>

            <!-- Statistics -->
            <div class="stats-mini">
                <div class="stat-mini">
                    <div class="stat-mini-value">{{ $totalUsers }}</div>
                    <div class="stat-mini-label">Total Users</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-value">{{ $adminCount }}</div>
                    <div class="stat-mini-label">Admins</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-value">{{ $memberCount }}</div>
                    <div class="stat-mini-label">Members</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-value">{{ $sellerCount }}</div>
                    <div class="stat-mini-label">Sellers</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters-bar">
                <a href="{{ route('admin.users.index') }}" class="filter-tab {{ !request('role') ? 'active' : '' }}">
                    All Users
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="filter-tab {{ request('role') == 'admin' ? 'active' : '' }}">
                    Admins
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'member']) }}" class="filter-tab {{ request('role') == 'member' ? 'active' : '' }}">
                    Members
                </a>

                <form method="GET" action="{{ route('admin.users.index') }}" class="search-box">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search users..." 
                        value="{{ request('search') }}"
                        class="search-input">
                </form>
            </div>

            <!-- Users Table -->
            <div class="users-table-card">
                @if($users->isEmpty())
                    <div class="empty-state">
                        <p>No users found</p>
                    </div>
                @else
                    <div class="table-wrapper">
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Store</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="user-avatar">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div class="user-info">
                                                    <h4>{{ $user->name }}</h4>
                                                    <div class="user-email">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($user->role === 'admin')
                                                <span class="badge badge-danger">Admin</span>
                                            @else
                                                <span class="badge badge-info">Member</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->store)
                                                <span class="badge badge-success">
                                                    🏪 {{ $user->store->name }}
                                                </span>
                                            @else
                                                <span style="color: var(--gray); font-size: 14px;">-</span>
                                            @endif
                                        </td>
                                        <td style="font-size: 14px; color: var(--gray);">
                                            {{ $user->created_at->format('d M Y') }}
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.users.show', $user) }}" class="btn-icon" title="View">
                                                    👁️
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div style="padding: var(--spacing-lg);">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection