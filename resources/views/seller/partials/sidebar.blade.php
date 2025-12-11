<aside class="seller-sidebar">
    <div class="store-header">
        <img 
            src="{{ auth()->user()->store->logo ? asset('storage/' . auth()->user()->store->logo) : asset('images/default-store.png') }}" 
            alt="{{ auth()->user()->store->name }}"
            class="store-logo">
        <div class="store-name">{{ auth()->user()->store->name }}</div>
        <div class="store-status">
            @if(auth()->user()->store->is_verified)
                <span class="badge badge-success">✓ Verified</span>
            @else
                <span class="badge badge-warning">⏳ Pending</span>
            @endif
        </div>
    </div>

    <ul class="seller-nav">
        <li class="seller-nav-item">
            <a href="{{ route('seller.dashboard') }}" class="seller-nav-link {{ $activeMenu === 'dashboard' ? 'active' : '' }}">
                📊 Dashboard
            </a>
        </li>
        <li class="seller-nav-item">
            <a href="{{ route('seller.products.index') }}" class="seller-nav-link {{ $activeMenu === 'products' ? 'active' : '' }}">
                📦 Products
            </a>
        </li>
        <li class="seller-nav-item">
            <a href="{{ route('seller.categories.index') }}" class="seller-nav-link {{ $activeMenu === 'categories' ? 'active' : '' }}">
                🏷️ Categories
            </a>
        </li>
        <li class="seller-nav-item">
            <a href="{{ route('seller.orders.index') }}" class="seller-nav-link {{ $activeMenu === 'orders' ? 'active' : '' }}">
                🛒 Orders
            </a>
        </li>
        <li class="seller-nav-item">
            <a href="{{ route('seller.balance.index') }}" class="seller-nav-link {{ $activeMenu === 'balance' ? 'active' : '' }}">
                💰 Balance
            </a>
        </li>
        <li class="seller-nav-item">
            <a href="{{ route('seller.withdrawal.index') }}" class="seller-nav-link {{ $activeMenu === 'withdrawal' ? 'active' : '' }}">
                💳 Withdrawal
            </a>
        </li>
        <li class="seller-nav-item">
            <a href="{{ route('seller.store.edit') }}" class="seller-nav-link {{ $activeMenu === 'settings' ? 'active' : '' }}">
                ⚙️ Store Settings
            </a>
        </li>
    </ul>
</aside>