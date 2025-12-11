<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DrizStuff - Your Trusted Marketplace')</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>

<body>
    <!-- Alert Messages (Tanpa Navbar) -->
    @if(session('success'))
    <div class="container mt-md">
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container mt-md">
        <div class="alert alert-danger">
            ❌ {{ session('error') }}
        </div>
    </div>
    @endif

    @if(session('info'))
    <div class="container mt-md">
        <div class="alert alert-info">
            ℹ️ {{ session('info') }}
        </div>
    </div>
    @endif

    @if(session('warning'))
    <div class="container mt-md">
        <div class="alert alert-warning">
            ⚠️ {{ session('warning') }}
        </div>
    </div>
    @endif

    <!-- Main Content (Tanpa Navbar & Footer) -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>

</html>