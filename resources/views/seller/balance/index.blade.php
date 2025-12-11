@extends('layouts.app')

@section('title', 'Balance - DrizStuff')

@push('styles')
<style>
.seller-layout {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: var(--spacing-xl);
    padding: var(--spacing-2xl) 0;
}

.balance-content {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-lg);
}

.balance-card {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--spacing-2xl);
    box-shadow: var(--shadow-lg);
}

.balance-label {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: var(--spacing-sm);
}

.balance-amount {
    font-size: 48px;
    font-weight: 700;
    margin-bottom: var(--spacing-lg);
}

.balance-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--spacing-lg);
}

.balance-stat {
    background: rgba(255, 255, 255, 0.1);
    padding: var(--spacing-md);
    border-radius: var(--radius-md);
}

.stat-label {
    font-size: 12px;
    opacity: 0.8;
    margin-bottom: 4px;
}

.stat-value {
    font-size: 20px;
    font-weight: 600;
}

.history-card {
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

.filter-group {
    display: flex;
    gap: var(--spacing-sm);
}

.filter-select {
    padding: 8px 12px;
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 14px;
}

.history-list {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.history-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--spacing-md);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
}

.history-icon {
    font-size: 32px;
    margin-right: var(--spacing-md);
}

.history-info {
    flex: 1;
}

.history-type {
    font-weight: 600;
    margin-bottom: 4px;
}

.history-date {
    font-size: 12px;
    color: var(--gray);
}

.history-remarks {
    font-size: 14px;
    color: var(--gray);
    margin-top: 4px;
}

.history-amount {
    font-size: 20px;
    font-weight: 700;
}

.amount-income {
    color: var(--success);
}

.amount-withdraw {
    color: var(--danger);
}

.empty-state {
    text-align: center;
    padding: var(--spacing-2xl);
    color: var(--gray);
}

@media (max-width: 768px) {
    .seller-layout {
        grid-template-columns: 1fr;
    }
    
    .balance-stats {
        grid-template-columns: 1fr;
    }
    
    .history-item {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--spacing-sm);
    }
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="seller-layout">
        <!-- Sidebar -->
        @include('seller.partials.sidebar', ['activeMenu' => 'balance'])

        <!-- Main Content -->
        <main class="balance-content">
            <h1>💰 Balance</h1>

            <!-- Balance Card -->
            <div class="balance-card">
                <div class="balance-label">Current Balance</div>
                <div class="balance-amount">
                    Rp {{ number_format($storeBalance->balance, 0, ',', '.') }}
                </div>

                <div class="balance-stats">
                    <div class="balance-stat">
                        <div class="stat-label">Total Income</div>
                        <div class="stat-value">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                    </div>
                    <div class="balance-stat">
                        <div class="stat-label">Total Withdrawn</div>
                        <div class="stat-value">Rp {{ number_format($totalWithdraw, 0, ',', '.') }}</div>
                    </div>
                </div>

                <a href="{{ route('seller.withdrawal.index') }}" class="btn btn-secondary" style="margin-top: var(--spacing-lg); width: 100%;">
                    💳 Request Withdrawal
                </a>
            </div>

            <!-- Transaction History -->
            <div class="history-card">
                <div class="card-header">
                    <h2 class="card-title">📊 Transaction History</h2>

                    <form method="GET" action="{{ route('seller.balance.index') }}" class="filter-group">
                        <select name="type" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Types</option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Income</option>
                            <option value="withdraw" {{ request('type') == 'withdraw' ? 'selected' : '' }}>Withdraw</option>
                        </select>
                    </form>
                </div>

                @if($histories->isEmpty())
                    <div class="empty-state">
                        <p>No transaction history yet</p>
                    </div>
                @else
                    <div class="history-list">
                        @foreach($histories as $history)
                            <div class="history-item">
                                <div style="display: flex; align-items: center; flex: 1;">
                                    <div class="history-icon">
                                        @if($history->type === 'income')
                                            ⬇️
                                        @else
                                            ⬆️
                                        @endif
                                    </div>
                                    <div class="history-info">
                                        <div class="history-type">
                                            {{ ucfirst($history->type) }}
                                        </div>
                                        <div class="history-date">
                                            {{ $history->created_at->format('d M Y, H:i') }}
                                        </div>
                                        @if($history->remarks)
                                            <div class="history-remarks">
                                                {{ $history->remarks }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="history-amount {{ $history->type === 'income' ? 'amount-income' : 'amount-withdraw' }}">
                                    {{ $history->type === 'income' ? '+' : '-' }} 
                                    Rp {{ number_format($history->amount, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div style="margin-top: var(--spacing-lg);">
                        {{ $histories->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection