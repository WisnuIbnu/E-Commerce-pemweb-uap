<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- TAMBAHKAN BARIS INI -->
    <title>@yield('title', 'Tumbloo - Platform Jual Beli Tumblr')</title>
    
    <!-- Tailwind CSS -->
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-white font-sans antialiased">
    
    <!-- Navbar Component -->
    <x-navbar />
    
    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>
    
    <!-- Footer Component -->
    <x-footer />
    
    @stack('scripts')
</body>
</html>