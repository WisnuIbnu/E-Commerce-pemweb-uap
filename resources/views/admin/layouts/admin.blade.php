<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --soft-blue: #cfe8ff;
            --soft-pink: #ffd6e8;
            --deep-blue: #7bb8e8;
            --deep-pink: #ffb9cf;
            --text-dark: #333;
        }

        body {
            background: var(--soft-blue);
            font-family: 'Inter', sans-serif;
        }

        /* NAVBAR */
        .admin-navbar {
            background: var(--soft-pink);
            padding: 14px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid var(--deep-pink);
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }

        .nav-links a {
            margin-right: 26px;
            font-weight: 600;
            color: var(--text-dark);
            transition: 0.25s ease-in-out;
            font-size: 16px;
        }

        .nav-links a:hover {
            color: black;
            text-decoration: underline;
        }

        /* Logout Button */
        .logout-btn {
            background: var(--deep-blue);
            color: white;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #5da4d6;
        }

        /* WRAPPER CARD */
        .admin-container {
            margin: 30px auto;
            width: 90%;
            background: white;
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        /* TABLE STYLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 2px solid var(--deep-blue);
            padding: 12px;
            font-size: 15px;
        }

        th {
            background: var(--soft-blue);
            font-weight: 700;
        }

        tr:nth-child(even) {
            background: #f7faff;
        }

        /* BUTTONS */
        .btn {
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            transition: .2s;
        }

        .btn-approve {
            background: #a7e3b0;
            color: #075d17;
        }
        .btn-approve:hover { background: #8fd699; }

        .btn-reject {
            background: #ffb3c6;
            color: #7a0a1a;
        }
        .btn-reject:hover { background: #ff98b2; }

        .btn-edit {
            background: #90c8ff;
            color: #003b73;
        }
        .btn-edit:hover { background: #7bbaff; }

        .btn-delete {
            background: #ff9c9c;
            color: #630000;
        }
        .btn-delete:hover { background: #ff8282; }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <div class="admin-navbar">
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.users.index') }}">Users</a>
            <a href="{{ route('admin.stores.index') }}">Stores</a>
        </div>

        <form action="/logout" method="POST">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="admin-container">
        @yield('content')
    </div>

</body>
</html>
