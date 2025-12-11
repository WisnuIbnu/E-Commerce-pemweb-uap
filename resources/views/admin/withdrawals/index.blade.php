@extends('layouts.app')

@section('title', 'Withdrawals Management - DrizStuff')

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

.withdrawals-content {
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
    grid-template-columns: repeat(5, 1fr);
    gap: var(--spacing-md);
}

.stat-mini {
    background: var(--white);
    padding: var(--spacing-lg);
    border-radius: var(--radius-lg);
    text-align: center;
}

.stat-mini-value {
    font-size: 24px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: var(--spacing-xs);
}

.stat-mini-label {
    font-size: 12px;
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

.withdrawals-list {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.withdrawal-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--spacing-lg);
    box-shadow: var(--shadow-sm);
    transition: all 0.3s;
}

.withdrawal-card:hover {
    box-shadow: var(--shadow-lg);
}

.withdrawal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: var(--spacing-md);
    border-bottom: 1px solid var(--border);
    margin-bottom: var(--spacing-md);
}

.withdrawal-amount {
    font-size: 24px;
    font-weight: 700;
    color: var(--primary);
}

.withdrawal-info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--spacing-md);
    margin-bottom: var(--spacing-md);
}

.info-item {
    font-size: 14px;
}

.info-label {
    color: var(--gray);
    margin-bottom: 4px;
}

.info-value {
    font-weight: 600;
}

.withdrawal-actions {
    display: flex;
    gap: var(--spacing-sm);
    padding-top: var(--spacing-md);
    border-top: 1px solid var(--border);
}

.empty-state {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--spacing-2xl);
    text-align: center;
}

.empty-icon {
    font-size: 64px;
    margin-bottom: var(--spacing-md);
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
    
    .withdrawal-info-grid {
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
                    <a href="{{ route('admin.users.index') }}" class="admin-nav-link">
                        👥 Users
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.withdrawals.index') }}" class="admin-nav-link active">
                        💳 Withdrawals
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="withdrawals-content">
            <div class="page-header">
                <h1>💳 Withdrawals Management</h1>
            </div>

            <!-- Statistics -->
            <div class="stats-mini">
                <div class="stat-mini">
                    <div class="stat-mini-value">{{ $totalWithdrawals }}</div>
                    <div class="stat-mini-label">Total</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-value">{{ $pendingWithdrawals }}</div>
                    <div class="stat-mini-label">Pending</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-value">{{ $approvedWithdrawals }}</div>
                    <div class="stat-mini-label">Approved</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-value">{{ $rejectedWithdrawals }}</div>
                    <div class="stat-mini-label">Rejected</div>
                </div>
                <div class="stat-mini">
                    <div class="stat-mini-value">Rp {{ number_format($totalAmount / 1000000, 1) }}M</div>
                    <div class="stat-mini-label">Total Amount</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters-bar">
                <a href="{{ route('admin.withdrawals.index') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">
                    All
                </a>
                <a href="{{ route('admin.withdrawals.index', ['status' => 'pending']) }}" class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}">
                    Pending
                </a>
                <a href="{{ route('admin.withdrawals.index', ['status' => 'approved']) }}" class="filter-tab {{ request('status') == 'approved' ? 'active' : '' }}">
                    Approved
                </a>
                <a href="{{ route('admin.withdrawals.index', ['status' => 'rejected']) }}" class="filter-tab {{ request('status') == 'rejected' ? 'active' : '' }}">
                    Rejected
                </a>

                <form method="GET" action="{{ route('admin.withdrawals.index') }}" class="search-box">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search by store name..." 
                        value="{{ request('search') }}"
                        class="search-input">
                </form>
            </div>

            <!-- Withdrawals List -->
            @if($withdrawals->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">💳</div>
                    <h3>No withdrawal requests</h3>
                    <p style="color: var(--gray);">Withdrawal requests will appear here</p>
                </div>
            @else
                <div class="withdrawals-list">
                    @foreach($withdrawals as $withdrawal)
                        <div class="withdrawal-card">
                            <div class="withdrawal-header">
                                <div class="withdrawal-amount">
                                    Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                </div>
                                @if($withdrawal->status === 'pending')
                                    <span class="badge badge-warning">⏳ Pending</span>
                                @elseif($withdrawal->status === 'approved')
                                    <span class="badge badge-success">✓ Approved</span>
                                @else
                                    <span class="badge badge-danger">✗ Rejected</span>
                                @endif
                            </div>

                            <div class="withdrawal-info-grid">
                                <div class="info-item">
                                    <div class="info-label">Store</div>
                                    <div class="info-value">{{ $withdrawal->storeBalance->store->name }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">Bank</div>
                                    <div class="info-value">{{ $withdrawal->bank_name }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">Account Number</div>
                                    <div class="info-value">{{ $withdrawal->bank_account_number }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">Account Name</div>
                                    <div class="info-value">{{ $withdrawal->bank_account_name }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">Request Date</div>
                                    <div class="info-value">{{ $withdrawal->created_at->format('d M Y, H:i') }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">Status</div>
                                    <div class="info-value">{{ ucfirst($withdrawal->status) }}</div>
                                </div>
                            </div>

                            <div class="withdrawal-actions">
                                <a href="{{ route('admin.withdrawals.show', $withdrawal) }}" class="btn btn-primary" style="flex: 1;">
                                    👁️ View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $withdrawals->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
@endsection