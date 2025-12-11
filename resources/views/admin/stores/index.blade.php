{{-- resources/views/admin/stores/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Stores Management')

@push('styles')
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #F9F9F9 0%, #E4D6C5 100%);
            min-height: 100vh;
        }

        .admin-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-header {
            background: linear-gradient(135deg, #984216 0%, #B85624 100%);
            padding: 40px;
            border-radius: 24px;
            margin-bottom: 40px;
            box-shadow: 0 8px 32px rgba(152, 66, 22, 0.2);
            color: white;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .page-title {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .page-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        .header-btn {
            padding: 14px 28px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            color: white;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            border: none;
        }

        .header-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-icon.total {
            background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
        }

        .stat-icon.verified {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
        }

        .stat-icon.unverified {
            background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
        }

        .stat-icon.products {
            background: linear-gradient(135deg, #F3E5F5 0%, #E1BEE7 100%);
        }

        .stat-label {
            font-size: 13px;
            color: #666;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 40px;
            font-weight: 800;
            color: #984216;
        }

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
            align-items: flex-end;
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
            background: linear-gradient(135deg, #984216 0%, #B85624 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(152, 66, 22, 0.3);
        }

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

        .verification-badge {
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .verification-badge.verified {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            color: #2E7D32;
        }

        .verification-badge.unverified {
            background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
            color: #E65100;
        }

        .verification-badge:hover {
            transform: scale(1.05);
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

        .btn-edit {
            background: linear-gradient(135deg, #8D957E 0%, #9BA789 100%);
            color: white;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(141, 149, 126, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #F44336 0%, #EF5350 100%);
            color: white;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(244, 67, 54, 0.3);
        }

        .btn-view {
            background: linear-gradient(135deg, #2196F3 0%, #42A5F5 100%);
            color: white;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(33, 150, 243, 0.3);
        }

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
            max-width: 700px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            margin-bottom: 32px;
        }

        .modal-title {
            font-size: 28px;
            font-weight: 800;
            color: #984216;
            margin-bottom: 8px;
        }

        .modal-subtitle {
            font-size: 14px;
            color: #666;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #666;
            margin-bottom: 8px;
            display: block;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #E4D6C5;
            border-radius: 12px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #984216;
            box-shadow: 0 0 0 4px rgba(152, 66, 22, 0.1);
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 8px;
        }

        .form-checkbox input {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 32px;
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

        .modal-btn-submit {
            background: linear-gradient(135deg, #984216 0%, #B85624 100%);
            color: white;
        }

        .modal-btn-submit:hover {
            box-shadow: 0 6px 16px rgba(152, 66, 22, 0.3);
        }

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
            border-left: 4px solid #4CAF50;
        }

        .notification.active {
            display: flex;
            animation: slideInRight 0.3s ease-out;
        }

        .notification.error {
            border-left-color: #F44336;
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

        .empty-state {
            text-align: center;
            padding: 80px 20px;
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
        }
    </style>
@endpush

@section('content')
    <div class="admin-container">
        <div class="page-header">
            <div class="header-content">
                <div>
                    <h1 class="page-title">
                        <span>🏪</span>
                        Stores Management
                    </h1>
                    <p class="page-subtitle">Manage all stores on the platform</p>
                </div>
                <button onclick="openCreateModal()" class="header-btn">
                    <span>➕</span>
                    Add New Store
                </button>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label">Total Stores</span>
                    <div class="stat-icon total">🏪</div>
                </div>
                <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label">Verified</span>
                    <div class="stat-icon verified">✓</div>
                </div>
                <div class="stat-value">{{ $stats['verified'] ?? 0 }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label">Unverified</span>
                    <div class="stat-icon unverified">⏳</div>
                </div>
                <div class="stat-value">{{ $stats['unverified'] ?? 0 }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label">Products</span>
                    <div class="stat-icon products">📦</div>
                </div>
                <div class="stat-value">{{ $stats['total_products'] ?? 0 }}</div>
            </div>
        </div>

        <div class="filters-section">
            <form action="{{ route('admin.stores') }}" method="GET">
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">Verification Status</label>
                        <select name="status" class="filter-select">
                            <option value="">All Stores</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>Unverified</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Search Stores</label>
                        <input type="text" name="search" class="filter-input" placeholder="Store name or owner..." value="{{ request('search') }}">
                    </div>

                    <div class="filter-group" style="max-width: 150px;">
                        <button type="submit" class="filter-btn">Apply</button>
                    </div>
                </div>
            </form>
        </div>

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
                        <span class="verification-badge {{ $store->is_verified ? 'verified' : 'unverified' }}" 
                              onclick="toggleVerification({{ $store->id }}, {{ $store->is_verified ? 'true' : 'false' }})">
                            <span>{{ $store->is_verified ? '✓' : '⏳' }}</span>
                            {{ $store->is_verified ? 'Verified' : 'Unverified' }}
                        </span>
                    </div>

                    <div class="store-details">
                        <div class="detail-item">
                            <span class="detail-label">Store ID</span>
                            <span class="detail-value">#{{ $store->id }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Created</span>
                            <span class="detail-value">{{ $store->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Products</span>
                            <span class="detail-value">{{ $store->products_count ?? 0 }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">City</span>
                            <span class="detail-value">{{ $store->city ?? 'N/A' }}</span>
                        </div>
                    </div>

                    @if($store->about)
                    <div class="store-description">
                        <h4>📝 About Store</h4>
                        <p>{{ Str::limit($store->about, 200) }}</p>
                    </div>
                    @endif

                    <div class="action-buttons">
                        <button class="btn btn-edit" onclick="editStore({{ $store->id }})">
                            <span>✏️</span>
                            Edit
                        </button>
                        <button class="btn btn-view" onclick="window.location.href='{{ route('store.show', $store->id) }}'">
                            <span>👁</span>
                            View
                        </button>
                        <button class="btn btn-delete" onclick="deleteStore({{ $store->id }}, '{{ $store->name }}')">
                            <span>🗑️</span>
                            Delete
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">🏪</div>
                    <h3 class="empty-title">No Stores Found</h3>
                </div>
            @endforelse
        </div>

        @if($stores->hasPages())
        <div style="margin-top: 32px;">
            {{ $stores->links() }}
        </div>
        @endif
    </div>

    <!-- Store Modal -->
    <div class="modal" id="storeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Add New Store</h3>
                <p class="modal-subtitle">Fill in the store information</p>
            </div>
            <form id="storeForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                <div class="form-group" id="userSelectGroup">
                    <label class="form-label">Store Owner *</label>
                    <select name="user_id" class="form-select" required id="userSelect">
                        <option value="">Select owner...</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Store Name *</label>
                    <input type="text" name="name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">About Store</label>
                    <textarea name="about" class="form-textarea" placeholder="Describe the store..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-input" placeholder="+62...">
                </div>

                <div class="form-group">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-textarea" placeholder="Full address..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Postal Code</label>
                    <input type="text" name="postal_code" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_verified" value="1">
                        <span>Verify this store immediately</span>
                    </label>
                </div>

                <div class="modal-actions">
                    <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="modal-btn modal-btn-submit">Save Store</button>
                </div>
            </form>
        </div>
    </div>

    <div class="notification" id="notification">
        <span id="notifIcon">✓</span>
        <div>
            <div style="font-weight: 700; margin-bottom: 4px;" id="notifTitle">Success</div>
            <div style="font-size: 13px; color: #666;" id="notifMessage">Operation completed</div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Add New Store';
            document.getElementById('storeForm').action = '{{ route('admin.stores.store') }}';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('storeForm').reset();
            document.getElementById('userSelectGroup').style.display = 'block';
            
            // Load users
            fetch('{{ route('admin.stores.create') }}')
                .then(r => r.json())
                .then(data => {
                    const select = document.getElementById('userSelect');
                    select.innerHTML = '<option value="">Select owner...</option>';
                    data.users.forEach(user => {
                        select.innerHTML += `<option value="${user.id}">${user.name} (${user.email})</option>`;
                    });
                });

            document.getElementById('storeModal').classList.add('active');
        }

        function editStore(storeId) {
            fetch(`/admin/stores/${storeId}/edit`)
                .then(r => r.json())
                .then(store => {
                    document.getElementById('modalTitle').textContent = 'Edit Store';
                    document.getElementById('storeForm').action = `/admin/stores/${storeId}`;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('userSelectGroup').style.display = 'none';
                    
                    document.querySelector('[name="name"]').value = store.name;
                    document.querySelector('[name="about"]').value = store.about || '';
                    document.querySelector('[name="phone"]').value = store.phone || '';
                    document.querySelector('[name="city"]').value = store.city || '';
                    document.querySelector('[name="address"]').value = store.address || '';
                    document.querySelector('[name="postal_code"]').value = store.postal_code || '';
                    document.querySelector('[name="is_verified"]').checked = store.is_verified;
                    
                    document.getElementById('storeModal').classList.add('active');
                });
        }

        function closeModal() {
            document.getElementById('storeModal').classList.remove('active');
            document.getElementById('storeForm').reset();
        }

        function deleteStore(storeId, storeName) {
            if (!confirm(`Are you sure you want to delete "${storeName}"? This will also delete all products. This action cannot be undone.`)) return;

            fetch(`/admin/stores/${storeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showNotification('✓', 'Store Deleted', data.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification('✗', 'Error', data.message, true);
                }
            })
            .catch(() => showNotification('✗', 'Error', 'Something went wrong', true));
        }

        function toggleVerification(storeId, currentStatus) {
            const action = currentStatus ? 'unverify' : 'verify';
            if (!confirm(`Are you sure you want to ${action} this store?`)) return;

            fetch(`/admin/stores/${storeId}/toggle-verification`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showNotification('✓', 'Success', data.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification('✗', 'Error', data.message, true);
                }
            })
            .catch(() => showNotification('✗', 'Error', 'Something went wrong', true));
        }

        document.getElementById('storeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    showNotification('✓', 'Success', data.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification('✗', 'Error', data.message || 'Operation failed', true);
                }
            })
            .catch(() => showNotification('✗', 'Error', 'Something went wrong', true));
        });

        function showNotification(icon, title, message, isError = false) {
            const notification = document.getElementById('notification');
            notification.className = 'notification active' + (isError ? ' error' : '');
            document.getElementById('notifIcon').textContent = icon;
            document.getElementById('notifTitle').textContent = title;
            document.getElementById('notifMessage').textContent = message;
            setTimeout(() => notification.classList.remove('active'), 4000);
        }

        document.getElementById('storeModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
@endsection