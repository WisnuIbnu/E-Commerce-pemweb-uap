<!-- resources/views/admin/withdrawals/index.blade.php -->
<x-admin-layout>
<x-slot name="title">Withdrawal Requests - SORAÉ</x-slot>

<style>
.filter-tabs {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
    border-bottom: 2px solid var(--color-light);
}

.filter-tab {
    padding: 15px 25px;
    text-decoration: none;
    color: var(--color-tertiary);
    font-weight: 600;
    border-bottom: 3px solid transparent;
    transition: all 0.3s;
}

.filter-tab:hover,
.filter-tab.active {
    color: var(--color-primary);
    border-bottom-color: var(--color-primary);
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

.store-info {
    flex: 1;
}

.store-name {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--color-primary);
    margin-bottom: 5px;
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
    margin-bottom: 20px;
}

.action-buttons {
    display: flex;
    gap: 10px;
}
</style>

<div style="margin-bottom: 40px;">
    <h1 style="font-size: 2.5rem; color: var(--color-primary);">Withdrawal Requests</h1>
    <p style="color: var(--color-secondary);">Review and process withdrawal requests</p>
</div>

<div class="filter-tabs">
    <a href="{{ route('admin.withdrawals.index') }}" 
       class="filter-tab {{ !request('status') ? 'active' : '' }}">
        All Requests
    </a>
    <a href="{{ route('admin.withdrawals.index', ['status' => 'pending']) }}" 
       class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}">
        Pending
    </a>
    <a href="{{ route('admin.withdrawals.index', ['status' => 'completed']) }}" 
       class="filter-tab {{ request('status') == 'completed' ? 'active' : '' }}">
        Completed
    </a>
    <a href="{{ route('admin.withdrawals.index', ['status' => 'rejected']) }}" 
       class="filter-tab {{ request('status') == 'rejected' ? 'active' : '' }}">
        Rejected
    </a>
</div>

@forelse($withdrawals as $withdrawal)
    <div class="withdrawal-card">
        <div class="withdrawal-header">
            <div class="store-info">
                <div class="store-name">{{ $withdrawal->store->name }}</div>
                <div style="color: var(--color-tertiary); font-size: 0.9rem;">
                    Owner: {{ $withdrawal->store->buyer->name }}
                </div>
                <div style="color: var(--color-tertiary); font-size: 0.9rem; margin-top: 5px;">
                    Requested: {{ $withdrawal->created_at->format('d M Y, H:i') }}
                </div>
            </div>
            <div>
                <div class="withdrawal-amount">
                    Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                </div>
                <span class="status-badge status-{{ $withdrawal->status }}" style="margin-top: 10px; display: inline-block;">
                    {{ ucfirst($withdrawal->status) }}
                </span>
            </div>
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
            <div style="padding: 15px; background: #fff3cd; border-radius: 8px; margin-bottom: 15px;">
                <strong style="color: #856404;">Notes:</strong>
                <p style="color: #856404; margin-top: 5px;">{{ $withdrawal->notes }}</p>
            </div>
        @endif

        @if($withdrawal->isPending())
            <div class="action-buttons">
                <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal) }}" 
                      onsubmit="return confirm('Approve this withdrawal request?')" 
                      style="flex: 1;">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        ✅ Approve
                    </button>
                </form>

                <button onclick="document.getElementById('reject-form-{{ $withdrawal->id }}').style.display='block'" 
                        class="btn btn-danger" style="flex: 1;">
                    ❌ Reject
                </button>
            </div>

            <div id="reject-form-{{ $withdrawal->id }}" style="display: none; margin-top: 15px; padding: 20px; background: var(--color-light); border-radius: 10px;">
                <form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal) }}">
                    @csrf
                    <h3 style="color: var(--color-primary); margin-bottom: 10px;">Rejection Reason</h3>
                    <textarea name="notes" class="form-textarea" 
                              placeholder="Provide reason for rejection..." 
                              required style="margin-bottom: 10px;"></textarea>
                    <button type="submit" class="btn btn-danger" style="width: 100%;">
                        Submit Rejection
                    </button>
                </form>
            </div>
        @endif
    </div>
@empty
    <div style="background: var(--color-white); padding: 60px; border-radius: 15px; text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 20px;">💳</div>
        <h3 style="color: var(--color-primary); margin-bottom: 10px;">No Withdrawal Requests</h3>
        <p style="color: var(--color-secondary);">No withdrawal requests found</p>
    </div>
@endforelse

@if($withdrawals->hasPages())
    <div style="margin-top: 30px; display: flex; justify-content: center;">
        {{ $withdrawals->links() }}
    </div>
@endif

</x-admin-layout>
