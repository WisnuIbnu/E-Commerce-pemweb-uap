<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ELSHOP - Snack E-Commerce')</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    {{-- VITE CSS --}}
    @vite(['resources/css/buyer.css'])
    
    @stack('styles')
</head>
<body>
    {{-- HEADER --}}
    <x-buyer-header />

    {{-- MAIN CONTENT --}}
    <main class="buyer-container">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        @yield('content')
    </main>

    {{-- FOOTER --}}
    <x-buyer-footer />

    {{-- VITE JS --}}
    @vite(['resources/js/buyer.js'])
    
    @stack('scripts')
</body>
</html>