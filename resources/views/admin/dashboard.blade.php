@extends('admin.layout')

@section('content')
    <style>
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .dashboard-title {
            font-size: 26px;
            font-weight: 700;
            margin: 0;
        }

        .dashboard-subtitle {
            margin: 4px 0 0 0;
            color: #6b7280;
            font-size: 13px;
        }

        /* PROFIL ADMIN */
        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }

        .admin-avatar {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            background: #ff7a00;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
        }

        .admin-info {
            display: flex;
            flex-direction: column;
        }

        .admin-name {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            line-height: 1.2;
        }

        .admin-role {
            font-size: 11px;
            color: #6b7280;
            line-height: 1.2;
        }

        .badge-env {
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 500;
            background: #fef3c7;
            color: #92400e;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 18px 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 110px;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
        }

        .stat-footer {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 4px;
        }

        .stat-chip {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 500;
            background: #ecfdf3;
            color: #166534;
        }

        .section-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 20px 22px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-top: 4px;
        }

        .section-title {
            font-size: 15px;
            font-weight: 600;
            margin: 0 0 10px 0;
        }

        .section-desc {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 14px;
        }

        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .quick-link {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            font-size: 12px;
            color: #374151;
            text-decoration: none;
            background: #f9fafb;
            transition: 0.15s;
        }

        .quick-link:hover {
            background: #fffbeb;
            border-color: #f97316;
            color: #b45309;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>

    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Admin Dashboard</h1>
            <p class="dashboard-subtitle">
                Ringkasan cepat aktivitas di Sembako Mart.
            </p>
        </div>

        {{-- Profil admin --}}
        @php
            $admin = auth()->user();
            $initial = $admin ? mb_strtoupper(mb_substr($admin->name ?? 'A', 0, 1)) : 'A';
        @endphp

        <a href="{{ route('profile.edit') }}" class="admin-profile"
           style="text-decoration: none; color: inherit; cursor: pointer;">
            <div class="admin-avatar">
                {{ $initial }}
            </div>
            <div class="admin-info">
                <span class="admin-name">{{ $admin->name ?? 'Admin' }}</span>
                <span class="admin-role">{{ $admin->email ?? 'admin@example.com' }}</span>
            </div>
        </a>
    </div>

    {{-- Kartu statistik --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ $userCount }}</div>
            <div class="stat-footer">Semua pengguna terdaftar</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Total Produk</div>
            <div class="stat-value">{{ $productCount }}</div>
            <div class="stat-footer">Produk aktif dalam sistem</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Total Toko</div>
            <div class="stat-value">{{ $storeCount }}</div>
            <div class="stat-footer">Toko seller yang terdaftar</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Total Transaksi</div>
            <div class="stat-value">{{ $transactionCount }}</div>
            <div class="stat-footer">Transaksi yang tercatat</div>
        </div>
    </div>

    {{-- Bagian tambahan / quick actions --}}
    <div class="section-card">
        <h2 class="section-title">Aksi Cepat</h2>
        <p class="section-desc">
            Kelola module yang paling sering digunakan dari satu tempat.
        </p>

        <div class="quick-links">
            <a href="{{ route('admin.users.index') }}" class="quick-link">Kelola User</a>
            <a href="{{ route('admin.stores.index') }}" class="quick-link">Review Toko</a>
            <a href="{{ route('admin.products.index') }}" class="quick-link">Kelola Produk</a>
            <a href="{{ route('admin.transactions.index') }}" class="quick-link">Lihat Transaksi</a>
            <a href="{{ route('admin.withdrawals.index') }}" class="quick-link">Permintaan Withdraw</a>
        </div>
    </div>
@endsection
