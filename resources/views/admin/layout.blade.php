<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sembako Mart</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f8f8f8;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: #FF7A00;
            color: white;
            height: 100vh;
            padding: 25px 20px;
            position: fixed;
        }

        .sidebar h2 {
            margin: 0 0 25px 0;
            font-size: 24px;
            font-weight: 700;
        }

        .sidebar a {
            display: block;
            padding: 12px 15px;
            margin: 5px 0;
            background: rgba(255,255,255,0.15);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.3);
        }

        /* CONTENT */
        .content {
            margin-left: 260px;
            padding: 30px;
            width: calc(100% - 260px);
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        h1 {
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>

        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.users.index') }}">Users</a>
        <a href="{{ route('admin.stores.index') }}">Stores</a>
        <a href="{{ route('admin.categories.index') }}">Categories</a>
        <a href="{{ route('admin.products.index') }}">Products</a>
        <a href="{{ route('admin.transactions.index') }}">Transactions</a>
        <a href="{{ route('admin.withdrawals.index') }}">Withdrawals</a>
    </div>

    <div class="content">
        @yield('content')
    </div>

</body>
</html>
