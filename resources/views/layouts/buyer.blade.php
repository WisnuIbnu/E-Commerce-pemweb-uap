<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUNPIA SNACK - Buyer</title>

    @vite([
        'resources/css/buyer/buyer.css',
        'resources/js/app.js'
    ])
</head>
<body>

    <header class="buyer-header">
        <div class="logo-area">
            <img src="/images/lunpia-logo.png" class="logo">
            <h1>LUNPIA SNACK</h1>
        </div>

        <nav class="buyer-nav">
            <a href="{{ route('buyer.home') }}">Home</a>
            <a href="{{ route('buyer.products') }}">Products</a>
            <a href="{{ route('buyer.cart') }}">Cart</a>
            <a href="{{ route('buyer.profile') }}">Profile</a>
        </nav>
    </header>

    <main class="content">
        @yield('content')
    </main>

    <footer class="buyer-footer">
        <p>© 2025 LUNPIA SNACK Marketplace</p>
    </footer>

</body>
</html>