<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DrizStuff - @yield('title', 'Home')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    @include('layouts.nav')

    <!-- Alert Messages -->
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

    @if(session('warning'))
    <div class="container mt-md">
        <div class="alert alert-warning">
            ⚠️ {{ session('warning') }}
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

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>