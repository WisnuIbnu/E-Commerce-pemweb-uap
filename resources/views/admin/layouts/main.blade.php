<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f4f5f7; }
        .sidebar {
            width: 220px;
            height: 100vh;
            position: fixed;
            background: #343a40;
            padding-top: 20px;
        }
        .sidebar a { color: white; padding: 10px; display: block; text-decoration: none; }
        .sidebar a:hover { background: #495057; }
        .content { margin-left: 230px; padding: 25px; }
    </style>
</head>
<body>

    @include('admin.partials.sidebar')

    <div class="content">
        @yield('content')
    </div>

</body>
</html>