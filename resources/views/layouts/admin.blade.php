<!DOCTYPE html>
<html>
<head>
    <title>Admin - @yield('title')</title>
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.stores.index') }}">Store Approval</a>
            <a href="{{ route('admin.users.index') }}">Users</a>
            <a href="{{ route('admin.products.index') }}">Products</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
