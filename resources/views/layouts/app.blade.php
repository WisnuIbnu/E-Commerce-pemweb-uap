<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-lunpia-cream">

    <div class="min-h-screen flex">

        {{-- ========================== --}}
        {{-- ADMIN SIDEBAR (Hanya untuk Admin) --}}
        {{-- ========================== --}}
        @if(auth()->check() && auth()->user()->role == 'admin')
            <aside class="w-64 bg-white shadow-lg min-h-screen fixed top-0 left-0 p-6 z-50">
                @include('admin.partials.sidebar')
            </aside>
        @endif


        {{-- ========================== --}}
        {{-- MAIN CONTENT --}}
        {{-- ========================== --}}
        <div class="@if(auth()->check() && auth()->user()->role == 'admin') ml-64 @endif flex-1">

            {{-- NAVIGATION BAR --}}
            @include('layouts.navigation')

            {{-- PAGE HEADER --}}
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- PAGE CONTENT --}}
            <main class="p-6">
                {{ $slot }}
            </main>

        </div>

    </div>
</body>
</html>
