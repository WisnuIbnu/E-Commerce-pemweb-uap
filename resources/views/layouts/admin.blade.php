<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - PuffyBaby</title>
    
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

        /* Main Layout */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Content Area */
        .admin-content {
            flex: 1;
            min-width: 0;
            overflow-x: hidden;
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #984216 0%, #B85624 100%);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(152, 66, 22, 0.3);
            z-index: 998;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(152, 66, 22, 0.4);
        }

        .mobile-menu-btn:active {
            transform: scale(0.95);
        }

        /* Mobile Overlay */
        .mobile-overlay {
            display: none;
        }

        @media (max-width: 640px) {
            .mobile-menu-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .admin-layout {
                flex-direction: column;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        @include('layouts.navbar-admin')

        <!-- Main Content -->
        <div class="admin-content">
            @yield('content')
        </div>
    </div>

    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" onclick="toggleMobileMenu()" aria-label="Toggle Menu">
        ☰
    </button>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" onclick="toggleMobileMenu()"></div>

    @stack('scripts')
</body>
</html>