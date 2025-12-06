<!-- resources/views/admin/stores/verify.blade.php -->
<x-admin-layout>
<x-slot name="title">Verify Store - {{ $store->name }}</x-slot>

<style>
.verification-container {
    max-width: 1000px;
}

.store-preview {
    background: var(--color-white);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
    margin-bottom: 30px;
}

.store-banner {
    width: 100%;
    height: 300px;
    object-fit: cover;
    background: var(--color-light);
}

.store-header {
    padding: 30px;
    display: flex;
    gap: 30px;
    align-items: flex-start;
}

.store-logo-large {
    width: 150px;
    height: 150px;
    border-radius: 15px;
    object-fit: cover;
    background: var(--color-light);
    border: 5px solid var(--color-white);
    margin-top: -80px;
}

.store-info {
    flex: 1;
}

.store-info h1 {
    font-size: 2.5rem;
    color: var(--color-primary);
    margin-bottom: 15px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    padding: 30px;
    background: var(--color-light);
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.info-label {
    font-size: 0.85rem;
    color: var(--color-tertiary);
    font-weight: 600;
}

.info-value {
    color: var(--color-primary);
    font-size: 1.05rem;
}

.description-section {
    padding: 30px;
}

.action-section {
    background: var(--color-white);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(86, 28, 36, 0.08);
}

.action-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 20px;
}

.rejection-form {
    margin-top: 20px;
    padding: 20px;
    background: var(--color-light);
    border-radius: 10px;
    display: none;
}

.rejection-form.active {
    display: block;
}
</style>

<div class="verification-container">
    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.stores.pending') }}" style="color: var(--color-secondary); text-decoration: none;">
            ← Back to Pending Stores
        </a>
    </div>

    <div class="store-preview">
        @if($store->banner)
            <img src="{{ asset('storage/' . $store->banner) }}" alt="{{ $store->name }}" class="store-banner">
        @else
            <div class="store-banner" style="display: flex; align-items: center; justify-content: center; font-size: 4rem;">
                🏪
            </div>
        @endif

        <div class="store-header">
            @if($store->logo)
                <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="store-logo-large">
            @else
                <div class="store-logo-large" style="display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                    🏪
                </div>
            @endif

            <div class="store-info">
                <h1>{{ $store->name }}</h1>
                <p style="color: var(--color-secondary); font-size: 1.05rem; margin-bottom: 15px;">
                    Applied on {{ $store->created_at->format('d M Y, H:i') }}
                </p>
                <span style="padding: 8px 20px; background: #fff3cd; color: #856404; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                    ⏳ Pending Verification
                </span>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">👤 Owner Name</span>
                <span class="info-value">{{ $store->buyer->name }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">📧 Owner Email</span>
                <span class="info-value">{{ $store->buyer->email }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">📧 Store Email</span>
                <span class="info-value">{{ $store->email }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">📞 Phone Number</span>
                <span class="info-value">{{ $store->phone }}</span>
            </div>

            <div class="info-item" style="grid-column: 1 / -1;">
                <span class="info-label">📍 Address</span>
                <span class="info-value">{{ $store->address }}</span>
            </div>
        </div>

        <div class="description-section">
            <h2 style="color: var(--color-primary); margin-bottom: 15px; font-size: 1.5rem;">
                Store Description
            </h2>
            <p style="color: var(--color-secondary); line-height: 1.8; font-size: 1.05rem;">
                {{ $store->description }}
            </p>
        </div>
    </div>

    <div class="action-section">
        <h2 style="color: var(--color-primary); margin-bottom: 20px; font-size: 1.8rem;">
            Verification Actions
        </h2>

        <div class="action-buttons">
            <form method="POST" action="{{ route('admin.stores.approve', $store) }}" 
                  onsubmit="return confirm('Are you sure you want to approve this store?')">
                @csrf
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                    ✅ Approve Store
                </button>
            </form>

            <button onclick="document.getElementById('rejection-form').classList.toggle('active')" 
                    class="btn btn-danger" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                ❌ Reject Application
            </button>
        </div>

        <form method="POST" action="{{ route('admin.stores.reject', $store) }}" 
              id="rejection-form" class="rejection-form">
            @csrf
            <h3 style="color: var(--color-primary); margin-bottom: 15px;">Rejection Reason</h3>
            <textarea name="rejection_reason" class="form-textarea" 
                      placeholder="Please provide a detailed reason for rejection..." 
                      required style="margin-bottom: 15px;"></textarea>
            <button type="submit" class="btn btn-danger" style="width: 100%;">
                Submit Rejection
            </button>
        </form>
    </div>
</div>

</x-admin-layout>
