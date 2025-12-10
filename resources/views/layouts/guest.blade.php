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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side - Branding (Hidden on mobile) -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#1E3A8A] to-[#60A5FA] relative overflow-hidden items-center justify-center">
                <!-- Decorative Elements -->
                <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 text-center px-10 text-white">
                    <h1 class="font-bold text-5xl mb-4 tracking-tight">WALKUNO.</h1>
                    <p class="text-xl text-blue-100 font-light">The First Step to Greatness.</p>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full lg:w-1/2 bg-white flex flex-col justify-center items-center px-8 py-12 md:px-16">
                <div class="w-full max-w-md">
                    <div class="mb-8 flex justify-center">
                        <a href="/">
                            <img src="{{ asset('images/logo-walkuno.jpg') }}" alt="WalkUno Logo" class="w-48 h-auto">
                        </a>
                    </div>

                    {{ $slot }}
                    
                    <div class="mt-8 text-center text-sm text-gray-400">
                        &copy; 2025 WalkUno. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
