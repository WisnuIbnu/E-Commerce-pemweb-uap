<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<style>
    .dashboard-container {
        padding: 40px;
        max-width: 1600px;
        margin: 0 auto;
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
    }

    .page-subtitle {
        font-size: 16px;
        opacity: 0.9;
    }

    .header-btn {
        padding: 12px 24px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        color: white;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .header-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        padding: 32px;
        border-radius: 20px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        border: 2px solid #F0F0F0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #984216, #B85624);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(152, 66, 22, 0.12);
        border-color: #E4D6C5;
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .stat-icon.users { background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%); }
    .stat-icon.stores { background: linear-gradient(135deg, #F3E5F5 0%, #E1BEE7 100%); }
    .stat-icon.pending { background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%); }
    .stat-icon.products { background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%); }
    .stat-icon.orders { background: linear-gradient(135deg, #FCE4EC 0%, #F8BBD0 100%); }
    .stat-icon.revenue { background: linear-gradient(135deg, #E0F2F1 0%, #B2DFDB 100%); }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        font-size: 14px;
        color: #666;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 40px;
        font-weight: 800;
        color: #984216;
        line-height: 1;
    }

    .stat-trend {
        font-size: 12px;
        color: #4CAF50;
        font-weight: 600;
        margin-top: 8px;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 40px;
    }

    /* Chart Card */
    .chart-card {
        background: white;
        padding: 32px;
        border-radius: 20px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        border: 2px solid #F0F0F0;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .card-title {
        font-size: 20px;
        font-weight: 700;
        color: #333;
    }

    .card-subtitle {
        font-size: 13px;
        color: #999;
        font-weight: 500;
    }

    .chart-container {
        height: 300px;
        position: relative;
    }

    /* Store Distribution */
    .distribution-grid {
        display: grid;
        gap: 16px;
    }

    .distribution-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        background: #F9F9F9;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .distribution-item:hover {
        background: #F0F0F0;
        transform: translateX(4px);
    }

    .distribution-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .distribution-icon.pending { background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%); }
    .distribution-icon.approved { background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%); }
    .distribution-icon.rejected { background: linear-gradient(135deg, #FFEBEE 0%, #FFCDD2 100%); }

    .distribution-info {
        flex: 1;
    }

    .distribution-label {
        font-size: 14px;
        color: #666;
        margin-bottom: 4px;
    }

    .distribution-value {
        font-size: 24px;
        font-weight: 700;
        color: #984216;
    }

    /* Tables */
    .table-section {
        background: white;
        padding: 32px;
        border-radius: 20px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        border: 2px solid #F0F0F0;
        margin-bottom: 24px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: linear-gradient(135deg, #F9F9F9 0%, #FEFEFE 100%);
    }

    th {
        padding: 16px;
        text-align: left;
        font-size: 13px;
        font-weight: 700;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #F0F0F0;
    }

    td {
        padding: 16px;
        border-bottom: 1px solid #F5F5F5;
        font-size: 14px;
        color: #333;
    }

    tbody tr:hover {
        background: #FAFAFA;
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .badge.pending { background: #FFF3E0; color: #E65100; }
    .badge.approved { background: #E8F5E9; color: #2E7D32; }

    .action-btn {
        padding: 8px 16px;
        background: linear-gradient(135deg, #8D957E 0%, #9BA789 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(141, 149, 126, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 60px;
        margin-bottom: 16px;
        opacity: 0.3;
    }

    @media (max-width: 1200px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .dashboard-container {
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
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Dashboard Header -->
    <div class="page-header">
        <div class="header-content">
            <div>
                <h1 class="page-title">👋 Welcome Back, Admin!</h1>
                <p class="page-subtitle">Here's what's happening with your platform today</p>
            </div>
            <a href="{{ route('admin.stores.verification') }}" class="header-btn">
                <span>🏪</span>
                Store Verification
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon users">👥</div>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ number_format($stats['total_users'] ?? 0) }}</div>
                <div class="stat-trend">↑ Active customers</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon stores">🏪</div>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Stores</div>
                <div class="stat-value">{{ number_format($stats['total_stores'] ?? 0) }}</div>
                <div class="stat-trend">All registered stores</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon pending">⏳</div>
            </div>
            <div class="stat-content">
                <div class="stat-label">Pending Stores</div>
                <div class="stat-value">{{ number_format($stats['pending_stores'] ?? 0) }}</div>
                <div class="stat-trend">Awaiting approval</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon products">📦</div>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Products</div>
                <div class="stat-value">{{ number_format($stats['total_products'] ?? 0) }}</div>
                <div class="stat-trend">Listed products</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon orders">🛒</div>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">{{ number_format($stats['total_orders'] ?? 0) }}</div>
                <div class="stat-trend">All time orders</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon revenue">💰</div>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</div>
                <div class="stat-trend">Completed orders</div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
        <!-- Revenue Chart -->
        <div class="chart-card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Revenue Overview</h3>
                    <p class="card-subtitle">Last 6 months performance</p>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Store Distribution -->
        <div class="chart-card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Store Status</h3>
                    <p class="card-subtitle">Current distribution</p>
                </div>
            </div>
            <div class="distribution-grid">
                <div class="distribution-item">
                    <div class="distribution-icon pending">⏳</div>
                    <div class="distribution-info">
                        <div class="distribution-label">Pending</div>
                        <div class="distribution-value">{{ $storeStats['pending'] ?? 0 }}</div>
                    </div>
                </div>
                <div class="distribution-item">
                    <div class="distribution-icon approved">✓</div>
                    <div class="distribution-info">
                        <div class="distribution-label">Approved</div>
                        <div class="distribution-value">{{ $storeStats['approved'] ?? 0 }}</div>
                    </div>
                </div>
                <div class="distribution-item">
                    <div class="distribution-icon rejected">✗</div>
                    <div class="distribution-info">
                        <div class="distribution-label">Rejected</div>
                        <div class="distribution-value">{{ $storeStats['rejected'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Stores Table -->
    <div class="table-section">
        <div class="card-header">
            <div>
                <h3 class="card-title">Pending Store Verification</h3>
                <p class="card-subtitle">Stores awaiting your approval</p>
            </div>
        </div>
        @if(isset($pendingStores) && $pendingStores->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Store Name</th>
                        <th>Owner</th>
                        <th>Applied Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingStores as $store)
                    <tr>
                        <td><strong>{{ $store->name }}</strong></td>
                        <td>{{ $store->user->name }}</td>
                        <td>{{ $store->created_at->format('d M Y') }}</td>
                        <td><span class="badge pending">Pending</span></td>
                        <td>
                            <a href="{{ route('admin.stores.verification') }}" class="action-btn">Review</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-icon">✓</div>
                <div>No pending stores at the moment</div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    const monthlyData = @json($monthlyRevenue ?? []);
    const labels = monthlyData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
    });
    const data = monthlyData.map(item => item.revenue);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue (Rp)',
                data: data,
                borderColor: '#984216',
                backgroundColor: 'rgba(152, 66, 22, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#984216',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#984216',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                        }
                    }
                },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush