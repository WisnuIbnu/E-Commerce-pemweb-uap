<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SweetMart' }}</title>

    @vite([
        'resources/css/app.css',
        'resources/css/pages/landing.css',
        'resources/js/app.js'
    ])
</head>

<body class="bg-softgray">

    {{-- NAVIGATION --}}
    @include('layouts.navigation')

    {{-- PAGE CONTENT --}}
    {{ $slot }}

    {{-- FOOTER --}}
    @include('layouts.footer')

</body>
</html>