<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SweetMart • {{ $title ?? 'Auth' }}</title>

    {{-- Font Lexend --}}
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #ffffff;
            font-family: 'Lexend', sans-serif;
        }
    </style>
</head>

<body style="
    background: url('/images/bg-blue-pink.png') center/cover no-repeat fixed;
    font-family: 'Lexend', sans-serif;
">
    <div class="d-flex justify-content-center align-items-center"
         style="min-height: 100vh; backdrop-filter: blur(2px);">
        {{ $slot }}
    </div>
</body>