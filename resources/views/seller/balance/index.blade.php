<!-- resources/views/seller/balance/index.blade.php -->
<x-seller-layout>
<x-slot name="title">Balance - SORAÉ</x-slot>

<style>
.balance-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.balance-card {
    background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
    color: var(--color-white);
    padding: 35px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(86, 28, 36, 0.2);
}

.balance-label {
    font-size: 0.95rem;
    opacity: 0.9;
    margin-bottom: 10px;
}

.balance-amount {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 20px;
}

.balance-card .btn {
    background: var(--color-white);
    color: var(--color-primary);
}

.balance-card .btn:hover {
    background: var(--color-light);
}

.stats-card {
    background: var(--color-white);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
}

.stats-label {
    color: var(--color-tertiary);
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.stats-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-primary);
}

.transaction-list {
    background: var(--color-white);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
}

.transaction-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid var(--color-light);
}

.transaction-item:last-child {
    border-bottom: none;
}

.transaction-info h4 {
    color: var(--color-primary);
    margin-bottom: 5px;
}

.transaction-info p {
    font-size: 0.9rem;
    color: var(--color-tertiary);
}

.transaction-amount {
    font-size: 1.3rem;
    font-weight: 700;
    color: #28a745;
}
</style>

<div style="margin-bottom: 30px;">
    <h1 style="font-size: 2.5rem; color: var(--color-primary);">Balance</h1>
    <p style="color: var(--color-secondary);">Manage your earnings and withdrawals</p>
</div>

<div class="balance-overview">
    <div class="balance-card">
        <div class="balance-label">Available Balance</div>
        <div class="balance-amount">Rp {{ number_format($store->balance, 0, ',', '.') }}</div>
        <a href="{{ route('seller.withdrawals.create') }}" class="btn" style="width: 100%;">
            💸 Withdraw Funds
        </a>
    </div>

    <div class="stats-card">
        <div class="stats-label">Total Earnings</div>
        <div class="stats-value">Rp {{ number_format($totalEarnings, 0, ',', '.') }}</div>
    </div>

    <div class="stats-card">
        <div class="stats-label">Total Withdrawn</div>
        <div class="stats-value">Rp {{ number_format($totalWithdrawn, 0, ',', '.') }}</div>
    </div>

    <div class="stats-card">
        <div class="stats-label">Pending Withdrawal</div>
        <div class="stats-value">Rp {{ number_format($pendingWithdrawal, 0, ',', '.') }}</div>
    </div>
</div>

<div class="transaction-list">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="color: var(--color-primary); font-size: 1.5rem;">Recent Transactions</h2>
        <a href="{{ route('seller.withdrawals.index') }}" class="btn btn-secondary">
            View Withdrawals
        </a>
    </div>

    @forelse($recentTransactions as $transaction)
        <div class="transaction-item">
            <div class="transaction-info">
                <h4>Order #{{ $transaction->id }}</h4>
                <p>{{ $transaction->buyer->name }} • {{ $transaction->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="transaction-amount">
                + Rp {{ number_format($transaction->total, 0, ',', '.') }}
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 40px; color: var(--color-tertiary);">
            <div style="font-size: 3rem; margin-bottom: 15px;">💰</div>
            <p>No transactions yet</p>
        </div>
    @endforelse
</div>

</x-seller-layout>


