<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SweetMart') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <p style="color:red;">TEST CSS</p>

    <div class="min-h-screen bg-gray-100">

        @include('layouts.navigation')
        @include('layouts.footer')

        <main class="py-6">

            {{-- FLASH MESSAGES --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- MODE 1: <x-app-layout> --}}
            @isset($slot)
                {{ $slot }}
            @endisset

            {{-- MODE 2: @extends --}}
            @yield('content')

        </main>
    </div>
</body>
</html>