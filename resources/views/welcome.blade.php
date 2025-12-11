<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/customer/category.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/card-product.css') }}">
</head>

<body class="font-sans antialiased bg-gray-100">

    <!-- ============================================================
         NAVBAR (Sama Persis Dengan Dashboard)
    ============================================================ -->
    @include('layouts.header')

    <!-- Page Wrapper -->
    <div class="min-h-screen">

        <!-- Hero Banner -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    @include('customer.hero-banner')
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        @include('customer.categories', ['categories' => $categories ?? []])

        <!-- Products Section -->
        @include('customer.card-product', ['products' => $products ?? []])
    </div>

</body>
</html>
