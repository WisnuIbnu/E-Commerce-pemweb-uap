<!-- resources/views/admin/stores/pending.blade.php -->
<x-admin-layout>
<x-slot name="title">Pending Store Registrations - SORAÉ</x-slot>

<style>
.page-header {
    margin-bottom: 40px;
}

.page-header h1 {
    font-size: 2.5rem;
    color: var(--color-primary);
    margin-bottom: 10px;
}

.stores-grid {
    display: grid;
    gap: 25px;
}

.store-card {
    background: var(--color-white);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
    display: grid;
    grid-template-columns: 200px 1fr auto;
    gap: 30px;
    align-items: center;
}

.store-logo {
    width: 200px;
    height: 200px;
    border-radius: 10px;
    object-fit: cover;
    background: var(--color-light);
}

.store-details h2 {
    font-size: 1.8rem;
    color: var(--color-primary);
    margin-bottom: 10px;
}

.detail-row {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
    font-size: 0.95rem;
}

.detail-label {
    color: var(--color-tertiary);
    min-width: 100px;
}

.detail-value {
    color: var(--color-primary);
    font-weight: 500;
}

.store-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

@media (max-width: 968px) {
    .store-card {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="page-header">
    <h1>Pending Store Registrations</h1>
    <p style="color: var(--color-secondary);">Review and approve store applications</p>
</div>

<div style="background: var(--color-light); padding: 20px; border-radius: 10px; margin-bottom: 30px;">
    <strong style="color: var(--color-primary);">📋 Total Pending:</strong> 
    <span style="color: var(--color-secondary); font-size: 1.2rem; font-weight: 600; margin-left: 10px;">
        {{ $pendingStores->total() }}
    </span>
</div>

<div class="stores-grid">
    @forelse($pendingStores as $store)
        <div class="store-card">
            @if($store->logo)
                <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="store-logo">
            @else
                <div class="store-logo" style="display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                    🏪
                </div>
            @endif

            <div class="store-details">
                <h2>{{ $store->name }}</h2>
                
                <div class="detail-row">
                    <span class="detail-label">Owner:</span>
                    <span class="detail-value">{{ $store->buyer->name }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $store->email }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $store->phone }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Applied:</span>
                    <span class="detail-value">{{ $store->created_at->format('d M Y, H:i') }}</span>
                </div>

                <p style="color: var(--color-secondary); margin-top: 15px; line-height: 1.6;">
                    {{ Str::limit($store->description, 150) }}
                </p>
            </div>

            <div class="store-actions">
                <a href="{{ route('admin.stores.verify', $store) }}" class="btn btn-primary">
                    👁️ Review Details
                </a>
            </div>
        </div>
    @empty
        <div style="background: var(--color-white); padding: 60px; border-radius: 15px; text-align: center;">
            <div style="font-size: 4rem; margin-bottom: 20px;">✅</div>
            <h3 style="color: var(--color-primary); margin-bottom: 10px;">All Caught Up!</h3>
            <p style="color: var(--color-secondary);">No pending store registrations</p>
        </div>
    @endforelse
</div>

@if($pendingStores->hasPages())
    <div style="margin-top: 30px; display: flex; justify-content: center;">
        {{ $pendingStores->links() }}
    </div>
@endif

</x-admin-layout>
