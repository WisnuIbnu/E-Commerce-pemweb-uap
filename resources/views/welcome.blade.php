<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

    </head>
    <body class="welcome-body">
        <header class="welcome-header">
            @if (Route::has('login'))
                <nav class="welcome-nav">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <div class="welcome-content">
            <h1>Selamat Datang di Klikly</h1>
            <p>Belanja dengan mudah dan cepat, tinggal klik dan dapatkan produk impianmu.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-6">
                Mulai Sekarang
            </a>
        </div>

        @if (Route::has('login'))
            <div class="welcome-footer-space"></div>
        @endif
    </body>
</html>