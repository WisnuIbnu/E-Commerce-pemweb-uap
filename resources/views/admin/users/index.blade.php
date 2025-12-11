{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Users Management')

@push('styles')
<style>
    .users-container {
        padding: 40px;
        max-width: 1600px;
        margin: 0 auto;
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
        font-weight: 700;
        font-size: 15px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
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

    .stat-icon.total { background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%); }
    .stat-icon.admin { background: linear-gradient(135deg, #F3E5F5 0%, #E1BEE7 100%); }
    .stat-icon.seller { background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%); }
    .stat-icon.member { background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%); }

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

    .filter-select, .filter-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #E4D6C5;
        border-radius: 12px;
        font-size: 14px;
        color: #333;
        background: white;
        transition: all 0.3s ease;
    }

    .filter-select:focus, .filter-input:focus {
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

    .table-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        border: 2px solid #F0F0F0;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: linear-gradient(135deg, #F9F9F9 0%, #FEFEFE 100%);
    }

    th {
        padding: 20px;
        text-align: left;
        font-size: 13px;
        font-weight: 700;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #F0F0F0;
    }

    td {
        padding: 20px;
        border-bottom: 1px solid #F5F5F5;
        font-size: 14px;
        color: #333;
    }

    tbody tr {
        transition: all 0.2s ease;
    }

    tbody tr:hover {
        background: #FAFAFA;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #E4D6C5 0%, #D4C4B5 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #984216;
        font-size: 16px;
        flex-shrink: 0;
    }

    .user-details h4 {
        font-size: 15px;
        font-weight: 700;
        color: #333;
        margin-bottom: 2px;
    }

    .user-details p {
        font-size: 13px;
        color: #999;
    }

    .badge {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: inline-block;
    }

    .badge.admin { background: linear-gradient(135deg, #F3E5F5 0%, #E1BEE7 100%); color: #7B1FA2; }
    .badge.seller { background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%); color: #2E7D32; }
    .badge.member { background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%); color: #1565C0; }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-edit {
        background: linear-gradient(135deg, #8D957E 0%, #9BA789 100%);
        color: white;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(141, 149, 126, 0.3);
    }

    .btn-delete {
        background: linear-gradient(135deg, #F44336 0%, #EF5350 100%);
        color: white;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
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
        max-width: 600px;
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

    .form-input, .form-select {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #E4D6C5;
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #984216;
        box-shadow: 0 0 0 4px rgba(152, 66, 22, 0.1);
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
        .users-container {
            padding: 20px;
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

        table {
            font-size: 12px;
        }

        th, td {
            padding: 12px;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="users-container">
    <div class="page-header">
        <div class="header-content">
            <div>
                <h1 class="page-title">
                    <span>👥</span>
                    Users Management
                </h1>
                <p class="page-subtitle">Manage all system users and their roles</p>
            </div>
            <button onclick="openCreateModal()" class="header-btn">
                <span>➕</span>
                Add New User
            </button>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Users</span>
                <div class="stat-icon total">👥</div>
            </div>
            <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Admins</span>
                <div class="stat-icon admin">👑</div>
            </div>
            <div class="stat-value">{{ $stats['admin'] ?? 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Sellers</span>
                <div class="stat-icon seller">🏪</div>
            </div>
            <div class="stat-value">{{ $stats['seller'] ?? 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Members</span>
                <div class="stat-icon member">👤</div>
            </div>
            <div class="stat-value">{{ $stats['member'] ?? 0 }}</div>
        </div>
    </div>

    <div class="filters-section">
        <form action="{{ route('admin.users') }}" method="GET">
            <div class="filters-row">
                <div class="filter-group">
                    <label class="filter-label">Role Filter</label>
                    <select name="role" class="filter-select">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="seller" {{ request('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                        <option value="member" {{ request('role') == 'member' ? 'selected' : '' }}>Member</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Search Users</label>
                    <input type="text" name="search" class="filter-input" placeholder="Name or email..." value="{{ request('search') }}">
                </div>

                <div class="filter-group" style="max-width: 150px;">
                    <button type="submit" class="filter-btn">Apply</button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-container">
        @if($users->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="user-details">
                                    <h4>{{ $user->name }}</h4>
                                    <p>{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $user->role ?? 'member' }}">
                                {{ ucfirst($user->role ?? 'member') }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <button onclick="editUser({{ $user->id }})" class="btn btn-edit">
                                    <span>✏️</span>
                                    Edit
                                </button>
                                @if($user->id !== Auth::id())
                                <button onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" class="btn btn-delete">
                                    <span>🗑️</span>
                                    Delete
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="padding: 24px;">
                {{ $users->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">👥</div>
                <h3 class="empty-title">No Users Found</h3>
            </div>
        @endif
    </div>
</div>

<!-- Create/Edit Modal -->
<div class="modal" id="userModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitle">Add New User</h3>
            <p class="modal-subtitle">Fill in the user information</p>
        </div>
        <form id="userForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="form-group">
                <label class="form-label">Full Name *</label>
                <input type="text" name="name" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address *</label>
                <input type="email" name="email" class="form-input" required>
            </div>

            <div class="form-group" id="passwordGroup">
                <label class="form-label">Password *</label>
                <input type="password" name="password" class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Role *</label>
                <select name="role" class="form-select" required>
                    <option value="member">Member</option>
                    <option value="seller">Seller</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="modal-actions">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="modal-btn modal-btn-submit">Save User</button>
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
@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Add New User';
        document.getElementById('userForm').action = '{{ route('admin.users.store') }}';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('userForm').reset();
        document.getElementById('passwordGroup').style.display = 'block';
        document.querySelector('#passwordGroup input').required = true;
        document.getElementById('userModal').classList.add('active');
    }

    function editUser(userId) {
        fetch(`/admin/users/${userId}/edit`)
            .then(r => r.json())
            .then(user => {
                document.getElementById('modalTitle').textContent = 'Edit User';
                document.getElementById('userForm').action = `/admin/users/${userId}`;
                document.getElementById('formMethod').value = 'PUT';
                document.querySelector('[name="name"]').value = user.name;
                document.querySelector('[name="email"]').value = user.email;
                document.querySelector('[name="role"]').value = user.role || 'member';
                document.getElementById('passwordGroup').style.display = 'none';
                document.querySelector('#passwordGroup input').required = false;
                document.getElementById('userModal').classList.add('active');
            });
    }

    function closeModal() {
        document.getElementById('userModal').classList.remove('active');
        document.getElementById('userForm').reset();
    }

    function deleteUser(userId, userName) {
        if (!confirm(`Are you sure you want to delete "${userName}"? This action cannot be undone.`)) return;

        fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showNotification('✓', 'User Deleted', data.message);
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification('✗', 'Error', data.message, true);
            }
        })
        .catch(() => showNotification('✗', 'Error', 'Something went wrong', true));
    }

    document.getElementById('userForm').addEventListener('submit', function(e) {
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

    document.getElementById('userModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endpush