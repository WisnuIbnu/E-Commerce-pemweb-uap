@extends('layouts.app')

@section('title', 'User Detail - DrizStuff')

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

.user-detail-content {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-lg);
}

.breadcrumb {
    display: flex;
    gap: var(--spacing-sm);
    font-size: 14px;
    color: var(--gray);
}

.breadcrumb a {
    color: var(--gray);
}

.breadcrumb a:hover {
    color: var(--primary);
}

.detail-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl);
    box-shadow: var(--shadow-sm);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--spacing-lg);
    padding-bottom: var(--spacing-md);
    border-bottom: 1px solid var(--border);
}

.card-title {
    font-size: 18px;
    font-weight: 600;
}

.user-profile {
    display: flex;
    gap: var(--spacing-xl);
    align-items: center;
}

.user-avatar-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    font-weight: 700;
}

.user-details {
    flex: 1;
}

.user-name-large {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: var(--spacing-sm);
}

.user-meta-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--spacing-md);
    margin-top: var(--spacing-lg);
}

.meta-box {
    padding: var(--spacing-md);
    background: var(--light-gray);
    border-radius: var(--radius-md);
}

.meta-label {
    font-size: 12px;
    color: var(--gray);
    margin-bottom: 4px;
}

.meta-value {
    font-weight: 600;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--spacing-lg);
}

.stat-box {
    text-align: center;
    padding: var(--spacing-lg);
    background: var(--light-gray);
    border-radius: var(--radius-md);
}

.stat-value-large {
    font-size: 32px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: var(--spacing-xs);
}

.stat-label {
    font-size: 14px;
    color: var(--gray);
}

.role-form {
    display: flex;
    gap: var(--spacing-md);
    align-items: end;
}

.danger-zone {
    background: #FEF2F2;
    border: 2px solid var(--danger);
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl);
}

.danger-zone h3 {
    color: var(--danger);
    margin-bottom: var(--spacing-md);
}

@media (max-width: 768px) {
    .admin-layout {
        grid-template-columns: 1fr;
    }
    
    .admin-sidebar {
        position: static;
    }
    
    .user-profile {
        flex-direction: column;
    }
    
    .user-meta-grid,
    .stats-grid {
        grid-template-columns: 1fr;
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
        <main class="user-detail-content">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span>›</span>
                <a href="{{ route('admin.users.index') }}">Users</a>
                <span>›</span>
                <span>{{ $user->name }}</span>
            </div>

            <h1>👤 User Details</h1>

            <!-- User Profile -->
            <div class="detail-card">
                <div class="user-profile">
                    <div class="user-avatar-large">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    
                    <div class="user-details">
                        <div class="user-name-large">{{ $user->name }}</div>
                        
                        <div style="margin-bottom: var(--spacing-md);">
                            @if($user->role === 'admin')
                                <span class="badge badge-danger" style="font-size: 14px;">Admin</span>
                            @else
                                <span class="badge badge-info" style="font-size: 14px;">Member</span>
                            @endif
                        </div>

                        <div class="user-meta-grid">
                            <div class="meta-box">
                                <div class="meta-label">Email</div>
                                <div class="meta-value">{{ $user->email }}</div>
                            </div>

                            <div class="meta-box">
                                <div class="meta-label">Joined</div>
                                <div class="meta-value">{{ $user->created_at->format('d M Y') }}</div>
                            </div>

                            <div class="meta-box">
                                <div class="meta-label">Store</div>
                                <div class="meta-value">
                                    @if($user->store)
                                        <a href="{{ route('admin.stores.show', $user->store) }}" style="color: var(--primary);">
                                            {{ $user->store->name }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            <div class="meta-box">
                                <div class="meta-label">Email Verified</div>
                                <div class="meta-value">
                                    @if($user->email_verified_at)
                                        <span class="badge badge-success">✓ Verified</span>
                                    @else
                                        <span class="badge badge-warning">✗ Not Verified</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">📊 User Statistics</h2>
                </div>

                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-value-large">{{ $totalPurchases }}</div>
                        <div class="stat-label">Total Purchases</div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-value-large">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                        <div class="stat-label">Total Spent</div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-value-large">Rp {{ number_format($storeRevenue, 0, ',', '.') }}</div>
                        <div class="stat-label">Store Revenue</div>
                    </div>
                </div>
            </div>

            <!-- Role Management -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">🔧 Role Management</h2>
                </div>

                <form method="POST" action="{{ route('admin.users.role.update', $user) }}" class="role-form">
                    @csrf
                    @method('PATCH')

                    <div class="form-group" style="flex: 1;">
                        <label for="role" class="form-label">User Role</label>
                        <select 
                            id="role" 
                            name="role" 
                            required
                            class="form-control">
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        💾 Update Role
                    </button>
                </form>
            </div>

            <!-- Danger Zone -->
            <div class="danger-zone">
                <h3>🗑️ Delete User</h3>
                <p style="color: var(--gray); margin-bottom: var(--spacing-lg);">
                    Permanently delete this user and all their data. This action cannot be undone.
                </p>
                
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you absolutely sure? This will delete all user data and cannot be undone!');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-secondary">
                        🗑️ Delete User
                    </button>
                </form>
            </div>

            <!-- Back Button -->
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-lg">
                ← Back to Users
            </a>
        </main>
    </div>
</div>
@endsection