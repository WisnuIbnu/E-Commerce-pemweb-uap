@extends('layouts.app')

@section('title', 'Withdrawal Detail - DrizStuff')

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

.withdrawal-detail-content {
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

.amount-display {
    text-align: center;
    padding: var(--spacing-2xl);
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: var(--radius-lg);
    color: var(--white);
    margin-bottom: var(--spacing-lg);
}

.amount-label {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: var(--spacing-sm);
}

.amount-value {
    font-size: 48px;
    font-weight: 700;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--spacing-lg);
}

.info-box {
    padding: var(--spacing-md);
    background: var(--light-gray);
    border-radius: var(--radius-md);
}

.info-label {
    font-size: 12px;
    color: var(--gray);
    margin-bottom: 4px;
}

.info-value {
    font-weight: 600;
    font-size: 16px;
}

.approval-actions {
    display: flex;
    gap: var(--spacing-md);
    padding: var(--spacing-lg);
    background: var(--light-gray);
    border-radius: var(--radius-lg);
}

.reject-form {
    margin-top: var(--spacing-md);
}

@media (max-width: 768px) {
    .admin-layout {
        grid-template-columns: 1fr;
    }
    
    .admin-sidebar {
        position: static;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .approval-actions {
        flex-direction: column;
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
        <main class="withdrawal-detail-content">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span>›</span>
                <a href="{{ route('admin.withdrawals.index') }}">Withdrawals</a>
                <span>›</span>
                <span>Withdrawal #{{ $withdrawal->id }}</span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h1>💳 Withdrawal Details</h1>
                @if($withdrawal->status === 'pending')
                    <span class="badge badge-warning" style="font-size: 16px; padding: 8px 16px;">⏳ Pending Review</span>
                @elseif($withdrawal->status === 'approved')
                    <span class="badge badge-success" style="font-size: 16px; padding: 8px 16px;">✓ Approved</span>
                @else
                    <span class="badge badge-danger" style="font-size: 16px; padding: 8px 16px;">✗ Rejected</span>
                @endif
            </div>

            <!-- Amount Display -->
            <div class="amount-display">
                <div class="amount-label">Withdrawal Amount</div>
                <div class="amount-value">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</div>
            </div>

            <!-- Store Information -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">🏪 Store Information</h2>
                </div>

                <div class="info-grid">
                    <div class="info-box">
                        <div class="info-label">Store Name</div>
                        <div class="info-value">{{ $withdrawal->storeBalance->store->name }}</div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Store Owner</div>
                        <div class="info-value">{{ $withdrawal->storeBalance->store->user->name }}</div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Owner Email</div>
                        <div class="info-value">{{ $withdrawal->storeBalance->store->user->email }}</div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Current Balance</div>
                        <div class="info-value">Rp {{ number_format($withdrawal->storeBalance->balance, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Bank Information -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">🏦 Bank Information</h2>
                </div>

                <div class="info-grid">
                    <div class="info-box">
                        <div class="info-label">Bank Name</div>
                        <div class="info-value">{{ $withdrawal->bank_name }}</div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Account Number</div>
                        <div class="info-value">{{ $withdrawal->bank_account_number }}</div>
                    </div>

                    <div class="info-box" style="grid-column: 1 / -1;">
                        <div class="info-label">Account Holder Name</div>
                        <div class="info-value">{{ $withdrawal->bank_account_name }}</div>
                    </div>
                </div>
            </div>

            <!-- Request Information -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">📋 Request Information</h2>
                </div>

                <div class="info-grid">
                    <div class="info-box">
                        <div class="info-label">Request Date</div>
                        <div class="info-value">{{ $withdrawal->created_at->format('d M Y, H:i') }}</div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Status</div>
                        <div class="info-value">{{ ucfirst($withdrawal->status) }}</div>
                    </div>

                    @if($withdrawal->status !== 'pending')
                        <div class="info-box">
                            <div class="info-label">Processed Date</div>
                            <div class="info-value">{{ $withdrawal->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Approval Actions -->
            @if($withdrawal->status === 'pending')
                <div class="approval-actions">
                    <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal) }}" style="flex: 1;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;" onclick="return confirm('Approve this withdrawal request?')">
                            ✓ Approve Withdrawal
                        </button>
                    </form>

                    <button type="button" class="btn btn-secondary btn-lg" style="flex: 1;" onclick="document.getElementById('rejectForm').style.display='block'">
                        ✗ Reject Withdrawal
                    </button>
                </div>

                <!-- Reject Form (Hidden by default) -->
                <div id="rejectForm" style="display: none;" class="detail-card">
                    <h3 style="margin-bottom: var(--spacing-md);">Reject Withdrawal</h3>
                    <form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="reason" class="form-label">Rejection Reason (Optional)</label>
                            <textarea 
                                id="reason" 
                                name="reason" 
                                rows="3"
                                class="form-control"
                                placeholder="Enter reason for rejection..."></textarea>
                        </div>

                        <div class="flex gap-md">
                            <button type="submit" class="btn btn-secondary">
                                Confirm Rejection
                            </button>
                            <button type="button" class="btn btn-outline" onclick="document.getElementById('rejectForm').style.display='none'">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Back Button -->
            <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-outline btn-lg">
                ← Back to Withdrawals
            </a>
        </main>
    </div>
</div>
@endsection