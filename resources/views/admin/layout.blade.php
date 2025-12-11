<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sembako Mart</title>
    {{-- Favicon baru --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/sembako-logo.svg') }}">
    <link rel="shortcut icon" href="{{ asset('images/sembako-logo.svg') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f8f8f8;
            display: flex;
            min-height: 100vh;     
        }

        .sidebar {
            width: 260px;
            background: #FF7A00;
            color: white;
            padding: 25px 20px;
            min-height: 100vh;
            box-sizing: border-box;
            flex-shrink: 0;
            transition: 0.3s;
            position: relative;
        }

        .sidebar.collapsed {
            width: 80px;
            padding: 25px 10px;
        }

        .sidebar h2 {
            margin: 0 0 25px 0;
            font-size: 22px;
            font-weight: 700;
            transition: 0.3s;
        }

        .sidebar.collapsed h2 {
            opacity: 0;
            pointer-events: none;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            margin: 5px 0;
            background: rgba(255,255,255,0.15);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.2s;
            width: 100%;
            box-sizing: border-box;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.3);
        }

        .sidebar a.active {
            background: rgba(255,255,255,0.35);
            font-weight: 600;
        }

        /* ICONS */
        .menu-icon {
            width: 22px;
            height: 22px;
            margin-right: 10px;
            flex-shrink: 0;
            transition: 0.2s;
        }

        .sidebar.collapsed .menu-icon {
            margin-right: 0;
        }

        .menu-text {
            display: inline-block;
            white-space: nowrap;
        }

        .sidebar.collapsed .menu-text {
            display: none;
        }

        .sidebar.collapsed a {
            justify-content: center;  
            padding: 10px 0;          
        }

        .content {
            flex: 1;
            padding: 30px;
            box-sizing: border-box;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .toggle-btn {
            background: transparent;
            color: white;
            border: none;
            font-size: 22px;
            cursor: pointer;
            padding: 0;
            margin-bottom: 15px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-pill.pending {
            background: #fff7ed;   
            color: #ea580c;        
            border: 1px solid #fed7aa;
        }

        .status-pill.waiting_confirmation {
            background: #eff6ff;   
            color: #1d4ed8;      
            border: 1px solid #bfdbfe;
        }

        .status-pill.paid {
            background: #ecfdf3;   
            color: #16a34a;        
            border: 1px solid #bbf7d0;
        }

        .status-pill.failed {
            background: #fef2f2;   
            color: #b91c1c;        
            border: 1px solid #fecaca;
        }
    </style>
</head>

<body>

    <div class="sidebar" id="sidebar">

        {{-- Tombol toggle sidebar --}}
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

        <h2><span class="menu-text">Admin Panel</span></h2>

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 9.75L12 3l9 6.75M4.5 9.75V21h15V9.75M9 21v-6h6v6" />
            </svg>
            <span class="menu-text">Dashboard</span>
        </a>

        {{-- Users --}}
        <a href="{{ route('admin.users.index') }}"
           class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 19.128a9.004 9.004 0 006.75-8.628V9a3 3 0 00-3-3h-1.5M12 3v1.5m0 15V21M3 15a6 6 0 016-6h6a6 6 0 016 6" />
            </svg>
            <span class="menu-text">User</span>
        </a>

        {{-- Stores --}}
        <a href="{{ route('admin.stores.index') }}"
           class="{{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
            <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 9.75L4.5 3h15L21 9.75M3 9.75H21M4.5 21h15V9.75M9 21v-6h6v6" />
            </svg>
            <span class="menu-text">Toko</span>
        </a>

        {{-- Products --}}
        <a href="{{ route('admin.products.index') }}"
           class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 7.5V16.5L12 21 3 16.5V7.5L12 3l9 4.5zM3 12l9 4.5 9-4.5" />
            </svg>
            <span class="menu-text">Produk</span>
        </a>

        {{-- Transactions --}}
        <a href="{{ route('admin.transactions.index') }}"
           class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
            <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 8.25V6a3 3 0 013-3h12a3 3 0 013 3v2.25M3 8.25A2.25 2.25 0 015.25 6h13.5A2.25 2.25 0 0121 8.25v9A2.25 2.25 0 0118.75 19.5H5.25A2.25 2.25 0 013 17.25v-9zM15 12h.008v.008H15V12z"/>
            </svg>
            <span class="menu-text">Transaksi</span>
        </a>

        {{-- Withdrawals --}}
        <a href="{{ route('admin.withdrawals.index') }}"
           class="{{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}">
            <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 7.5h18m-18 9h18M4.5 7.5a3 3 0 010 9m15 0a3 3 0 000-9M9 12h6" />
            </svg>
            <span class="menu-text">Withdrawals</span>
        </a>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" style="margin-top:25px;">
            @csrf
            <button style="
                width:100%;
                padding:10px 12px;
                background:#b91c1c;
                color:white;
                border:none;
                border-radius:8px;
                font-weight:500;
                cursor:pointer;
                transition:0.2s;
                display:flex;
                align-items:center;
                justify-content:center;
            " onmouseover="this.style.background='#dc2626'"
              onmouseout="this.style.background='#b91c1c'">

                <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H9" />
                </svg>

                <span class="menu-text">Logout</span>
            </button>
        </form>

    </div>

    <div class="content">
        @yield('content')
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
        }
    </script>

</body>
</html>
