{{-- resources/views/admin/stores/verification.blade.php --}}
@extends('layouts.admin')

@section('title', 'Store Verification')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .admin-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #984216 0%, #B85624 100%);
        padding: 40px;
        border-radius: 24px;
        margin-bottom: 40px;
        box-shadow: 0 8px 32px rgba(152, 66, 22, 0.2);
        color: white;
    }

    .page-title {
        font-size: 36px;
        font-weight: 800;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-title-icon {
        font-size: 40px;
    }

    .page-subtitle {
        font-size: 16px;
        opacity: 0.9;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        border: 2px solid #F0F0F0;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(152, 66, 22, 0.12);
        border-color: #E4D6C5;
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .stat-label {
        font-size: 14px;
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stat-icon.pending {
        background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
    }

    .stat-icon.approved {
        background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
    }

    .stat-icon.rejected {
        background: linear-gradient(135deg, #FFEBEE 0%, #FFCDD2 100%);
    }

    .stat-value {
        font-size: 40px;
        font-weight: 800;
        color: #984216;
        line-height: 1;
    }

    /* Filters */
    .filters-section {
        background: white;
        padding: 24px;
        border-radius: 20px;
        margin-bottom: 32px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        border: 2px solid #F0F0F0;
    }

    .filters-row {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-label {
        font-size: 13px;
        font-weight: 600;
        color: #666;
        margin-bottom: 8px;
        display: block;
    }

    .filter-select,
    .filter-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #E4D6C5;
        border-radius: 12px;
        font-size: 14px;
        color: #333;
        background: white;
        transition: all 0.3s ease;
    }

    .filter-select:focus,
    .filter-input:focus {
        outline: none;
        border-color: #984216;
        box-shadow: 0 0 0 4px rgba(152, 66, 22, 0.1);
    }

    .filter-btn {
        padding: 12px 24px;
        background: linear-gradient(135deg, #8D957E 0%, #9BA789 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(141, 149, 126, 0.3);
    }

    /* Stores Grid */
    .stores-grid {
        display: grid;
        gap: 24px;
    }

    .store-card {
        background: white;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        border: 2px solid #F0F0F0;
        transition: all 0.3s ease;
    }

    .store-card:hover {
        box-shadow: 0 12px 32px rgba(152, 66, 22, 0.12);
        border-color: #E4D6C5;
    }

    .store-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        gap: 20px;
    }

    .store-info {
        flex: 1;
    }

    .store-name {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
    }

    .store-owner {
        font-size: 14px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-badge {
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-badge.pending {
        background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
        color: #E65100;
    }

    .status-badge.approved {
        background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
        color: #2E7D32;
    }

    .status-badge.rejected {
        background: linear-gradient(135deg, #FFEBEE 0%, #FFCDD2 100%);
        color: #C62828;
    }

    .store-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        padding: 20px;
        background: linear-gradient(135deg, #F9F9F9 0%, #FEFEFE 100%);
        border-radius: 16px;
        margin-bottom: 24px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .detail-label {
        font-size: 12px;
        color: #999;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 15px;
        color: #333;
        font-weight: 600;
    }

    .store-description {
        background: #F9F9F9;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 24px;
    }

    .store-description h4 {
        font-size: 14px;
        color: #984216;
        margin-bottom: 12px;
        font-weight: 700;
    }

    .store-description p {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn {
        flex: 1;
        padding: 14px 24px;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-width: 140px;
    }

    .btn-approve {
        background: linear-gradient(135deg, #4CAF50 0%, #66BB6A 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }

    .btn-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(76, 175, 80, 0.4);
    }

    .btn-reject {
        background: linear-gradient(135deg, #F44336 0%, #EF5350 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
    }

    .btn-reject:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(244, 67, 54, 0.4);
    }

    .btn-view {
        background: linear-gradient(135deg, #8D957E 0%, #9BA789 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(141, 149, 126, 0.3);
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(141, 149, 126, 0.4);
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
    }

    .empty-icon {
        font-size: 80px;
        margin-bottom: 24px;
        opacity: 0.3;
    }

    .empty-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 12px;
    }

    .empty-text {
        font-size: 16px;
        color: #666;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 24px;
        padding: 40px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        margin-bottom: 24px;
    }

    .modal-title {
        font-size: 24px;
        font-weight: 700;
        color: #984216;
        margin-bottom: 8px;
    }

    .modal-subtitle {
        font-size: 14px;
        color: #666;
    }

    .modal-body {
        margin-bottom: 32px;
    }

    .modal-label {
        font-size: 14px;
        font-weight: 600;
        color: #666;
        margin-bottom: 12px;
        display: block;
    }

    .modal-textarea {
        width: 100%;
        min-height: 120px;
        padding: 16px;
        border: 2px solid #E4D6C5;
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
    }

    .modal-textarea:focus {
        outline: none;
        border-color: #984216;
        box-shadow: 0 0 0 4px rgba(152, 66, 22, 0.1);
    }

    .modal-actions {
        display: flex;
        gap: 12px;
    }

    .modal-btn {
        flex: 1;
        padding: 14px 24px;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .modal-btn-cancel {
        background: #E0E0E0;
        color: #666;
    }

    .modal-btn-cancel:hover {
        background: #D0D0D0;
    }

    .modal-btn-submit {
        background: linear-gradient(135deg, #984216 0%, #B85624 100%);
        color: white;
    }

    .modal-btn-submit:hover {
        box-shadow: 0 6px 16px rgba(152, 66, 22, 0.3);
    }

    /* Notification */
    .notification {
        position: fixed;
        top: 24px;
        right: 24px;
        background: white;
        padding: 20px 24px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        display: none;
        align-items: center;
        gap: 16px;
        min-width: 320px;
    }

    .notification.active {
        display: flex;
        animation: slideInRight 0.3s ease-out;
    }

    .notification-icon {
        font-size: 28px;
    }

    .notification-content {
        flex: 1;
    }

    .notification-title {
        font-size: 15px;
        font-weight: 700;
        color: #333;
        margin-bottom: 4px;
    }

    .notification-message {
        font-size: 13px;
        color: #666;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-container {
            padding: 20px 16px;
        }

        .page-header {
            padding: 28px 24px;
        }

        .page-title {
            font-size: 28px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .store-card {
            padding: 24px;
        }

        .store-header {
            flex-direction: column;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        .modal-content {
            padding: 28px 24px;
        }
    }
</style>
@endpush

@section('content')
<div class="admin-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <span class="page-title-icon">🏪</span>
            Store Verification
        </h1>
        <p class="page-subtitle">Review and manage store applications</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Pending</span>
                <div class="stat-icon pending">⏳</div>
            </div>
            <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Approved</span>
                <div class="stat-icon approved">✓</div>
            </div>
            <div class="stat-value">{{ $stats['approved'] ?? 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Rejected</span>
                <div class="stat-icon rejected">✗</div>
            </div>
            <div class="stat-value">{{ $stats['rejected'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form action="{{ route('admin.stores.verification') }}" method="GET">
            <div class="filters-row">
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-select">
                        <option value="">All Stores</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Search</label>
                    <input type="text" name="search" class="filter-input" placeholder="Store name or owner..." value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <button type="submit" class="filter-btn">Apply Filters</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Stores Grid -->
    <div class="stores-grid">
        @forelse($stores as $store)
            <div class="store-card">
                <div class="store-header">
                    <div class="store-info">
                        <h3 class="store-name">{{ $store->name }}</h3>
                        <p class="store-owner">
                            <span>👤</span>
                            Owner: {{ $store->user->name }} ({{ $store->user->email }})
                        </p>
                    </div>
                    <span class="status-badge {{ $store->is_verified ? 'approved' : 'pending' }}">
                        {{ $store->is_verified ? 'Approved' : 'Pending' }}
                    </span>
                </div>

                <div class="store-details">
                    <div class="detail-item">
                        <span class="detail-label">Store ID</span>
                        <span class="detail-value">#{{ $store->id }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Applied</span>
                        <span class="detail-value">{{ $store->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Products</span>
                        <span class="detail-value">{{ $store->products_count ?? 0 }}</span>
                    </div>
                </div>

                @if($store->description)
                <div class="store-description">
                    <h4>📝 Store Description</h4>
                    <p>{{ $store->description }}</p>
                </div>
                @endif

                <div class="action-buttons">
                    @if(!$store->is_verified)
                        <button class="btn btn-approve" onclick="approveStore({{ $store->id }}, '{{ $store->name }}')">
                            <span>✓</span>
                            Approve
                        </button>
                        <button class="btn btn-reject" onclick="openRejectModal({{ $store->id }}, '{{ $store->name }}')">
                            <span>✗</span>
                            Reject
                        </button>
                    @endif
                    <button class="btn btn-view" onclick="viewStore({{ $store->id }})">
                        <span>👁</span>
                        View Details
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3 class="empty-title">No Stores Found</h3>
                <p class="empty-text">There are no store applications matching your criteria.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Reject Modal -->
<div class="modal" id="rejectModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Reject Store Application</h3>
            <p class="modal-subtitle">Please provide a reason for rejection</p>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="modal-body">
                <label class="modal-label">Rejection Reason *</label>
                <textarea name="reason" class="modal-textarea" placeholder="Enter detailed reason for rejection..." required></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="modal-btn modal-btn-submit">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- Notification -->
<div class="notification" id="notification">
    <span class="notification-icon" id="notifIcon">✓</span>
    <div class="notification-content">
        <div class="notification-title" id="notifTitle">Success</div>
        <div class="notification-message" id="notifMessage">Action completed successfully</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function approveStore(storeId, storeName) {
        if (!confirm(`Are you sure you want to approve "${storeName}"?`)) return;

        fetch(`/admin/stores/${storeId}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showNotification('✓', 'Store Approved', `${storeName} has been approved successfully`);
                setTimeout(() => location.reload(), 1500);
            } else showNotification('✗', 'Error', data.message || 'Failed to approve store');
        })
        .catch(e => showNotification('✗', 'Error', 'Something went wrong'));
    }

    let currentStoreId = null;
    let currentStoreName = null;

    function openRejectModal(storeId, storeName) {
        currentStoreId = storeId;
        currentStoreName = storeName;
        document.getElementById('rejectModal').classList.add('active');
        document.querySelector('.modal-subtitle').textContent = `Store: ${storeName}`;
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('active');
        document.getElementById('rejectForm').reset();
        currentStoreId = null;
        currentStoreName = null;
    }

    document.getElementById('rejectForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const reason = this.querySelector('textarea[name="reason"]').value;

        fetch(`/admin/stores/${currentStoreId}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ reason })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                closeRejectModal();
                showNotification('✓', 'Store Rejected', `${currentStoreName} has been rejected`);
                setTimeout(() => location.reload(), 1500);
            } else showNotification('✗', 'Error', data.message || 'Failed to reject store');
        })
        .catch(e => showNotification('✗', 'Error', 'Something went wrong'));
    });

    function viewStore(storeId) {
        window.location.href = `/admin/stores/${storeId}`;
    }

    function showNotification(icon, title, message) {
        const notification = document.getElementById('notification');
        document.getElementById('notifIcon').textContent = icon;
        document.getElementById('notifTitle').textContent = title;
        document.getElementById('notifMessage').textContent = message;
        notification.classList.add('active');
        setTimeout(() => notification.classList.remove('active'), 4000);
    }

    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) closeRejectModal();
    });
</script>
@endpush