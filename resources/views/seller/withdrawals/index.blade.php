<!-- resources/views/seller/withdrawals/index.blade.php -->
<x-seller-layout>
<x-slot name="title">Withdrawals - SORAÉ</x-slot>

<style>
.withdrawals-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.withdrawal-card {
    background: var(--color-white);
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
    margin-bottom: 20px;
}

.withdrawal-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.withdrawal-amount {
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-primary);
}

.withdrawal-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    padding: 20px;
    background: var(--color-light);
    border-radius: 10px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.detail-label {
    font-size: 0.85rem;
    color: var(--color-tertiary);
}

.detail-value {
    font-weight: 600;
    color: var(--color-primary);
}
</style>

<div class="withdrawals-header">
    <div>
        <h1 style="font-size: 2.5rem; color: var(--color-primary);">Withdrawals</h1>
        <p style="color: var(--color-secondary);">Track your withdrawal requests</p>
    </div>
    <a href="{{ route('seller.withdrawals.create') }}" class="btn btn-primary">
        ➕ New Withdrawal
    </a>
</div>

<div style="background: var(--color-light); padding: 20px; border-radius: 10px; margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="color: var(--color-tertiary); font-size: 0.9rem; margin-bottom: 5px;">
                Available Balance
            </div>
            <div style="font-size: 2rem; font-weight: 700; color: var(--color-primary);">
                Rp {{ number_format($store->balance, 0, ',', '.') }}
            </div>
        </div>
        @if($store->balance >= 50000)
            <a href="{{ route('seller.withdrawals.create') }}" class="btn btn-primary">
                Request Withdrawal
            </a>
        @else
            <button class="btn btn-secondary" disabled>
                Minimum Rp 50,000
            </button>
        @endif
    </div>
</div>

@forelse($withdrawals as $withdrawal)
    <div class="withdrawal-card">
        <div class="withdrawal-header">
            <div>
                <div class="withdrawal-amount">
                    Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                </div>
                <div style="color: var(--color-tertiary); font-size: 0.9rem; margin-top: 5px;">
                    {{ $withdrawal->created_at->format('d M Y, H:i') }}
                </div>
            </div>
            <span class="status-badge status-{{ $withdrawal->status }}">
                {{ ucfirst($withdrawal->status) }}
            </span>
        </div>

        <div class="withdrawal-details">
            <div class="detail-item">
                <span class="detail-label">Bank Name</span>
                <span class="detail-value">{{ $withdrawal->bank_name }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Account Number</span>
                <span class="detail-value">{{ $withdrawal->account_number }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Account Name</span>
                <span class="detail-value">{{ $withdrawal->account_name }}</span>
            </div>
            @if($withdrawal->processed_at)
                <div class="detail-item">
                    <span class="detail-label">Processed At</span>
                    <span class="detail-value">{{ $withdrawal->processed_at->format('d M Y, H:i') }}</span>
                </div>
            @endif
        </div>

        @if($withdrawal->notes)
            <div style="margin-top: 15px; padding: 15px; background: #fff3cd; border-radius: 8px;">
                <strong style="color: #856404;">Admin Notes:</strong>
                <p style="color: #856404; margin-top: 5px;">{{ $withdrawal->notes }}</p>
            </div>
        @endif
    </div>
@empty
    <div style="background: var(--color-white); padding: 60px; border-radius: 15px; text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 20px;">💳</div>
        <h3 style="color: var(--color-primary); margin-bottom: 10px;">No Withdrawals Yet</h3>
        <p style="color: var(--color-secondary);">You haven't made any withdrawal requests</p>
    </div>
@endforelse

@if($withdrawals->hasPages())
    <div style="margin-top: 30px; display: flex; justify-content: center;">
        {{ $withdrawals->links() }}
    </div>
@endif

</x-seller-layout>