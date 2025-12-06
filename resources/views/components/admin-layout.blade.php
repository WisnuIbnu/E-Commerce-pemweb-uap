
<!-- UPDATE resources/views/components/admin-layout.blade.php -->
<!-- ADD THIS TO THE SIDEBAR MENU AFTER STORES MENU -->

<li class="menu-item">
    <a href="{{ route('admin.stores.index') }}" class="menu-link {{ request()->routeIs('admin.stores.index') ? 'active' : '' }}">
        <span class="menu-icon">🏪</span>
        <span>All Stores</span>
    </a>
</li>

<li class="menu-item">
    <a href="{{ route('admin.stores.pending') }}" class="menu-link {{ request()->routeIs('admin.stores.pending') || request()->routeIs('admin.stores.verify') ? 'active' : '' }}">
        <span class="menu-icon">⏳</span>
        <span>Pending Stores</span>
        @php
            $pendingCount = \App\Models\Store::where('status', 'pending')->count();
        @endphp
        @if($pendingCount > 0)
            <span style="background: #dc3545; color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; margin-left: 10px;">
                {{ $pendingCount }}
            </span>
        @endif
    </a>
</li>

<li class="menu-item">
    <a href="{{ route('admin.categories.index') }}" class="menu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <span class="menu-icon">📂</span>
        <span>Categories</span>
    </a>
</li>

<li class="menu-item">
    <a href="{{ route('admin.withdrawals.index') }}" class="menu-link {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}">
        <span class="menu-icon">💳</span>
        <span>Withdrawals</span>
        @php
            $pendingWithdrawals = \App\Models\Withdrawal::where('status', 'pending')->count();
        @endphp
        @if($pendingWithdrawals > 0)
            <span style="background: #ffc107; color: #856404; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; margin-left: 10px;">
                {{ $pendingWithdrawals }}
            </span>
        @endif
    </a>
</li>

