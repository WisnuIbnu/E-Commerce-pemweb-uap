<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ElecTrend - @yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-600 to-blue-800 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md px-6 py-8 bg-white/10 backdrop-blur-lg rounded-xl shadow-2xl border border-white/20">
        {{ $slot }}
    </div>

</body>
</html>
