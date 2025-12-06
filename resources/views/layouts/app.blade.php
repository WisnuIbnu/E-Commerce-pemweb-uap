{{-- File: resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PuffyBaby') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Google Fonts - Quicksand untuk header -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/css/auth/auth.css',
            'resources/css/header.css',
            'resources/css/footer.css',
            'resources/css/customer/banner.css',
            'resources/css/dashboard.css',
            'resources/js/app.js',
            'resources/js/header.js',
            'resources/js/footer.js'
        ])
    </head>
    <body class="font-sans antialiased">
        
        <!-- Header -->
        @include('layouts.header')

        <div class="min-h-screen bg-gray-100">
            <!-- Page Heading (Breadcrumb/Title) -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Footer -->
        @include('layouts.footer')
    </body>
</html>
