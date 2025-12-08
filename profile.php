// FILE: profile.php
<?php
session_start();

// CEK LOGIN
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
$current_user = $_SESSION["user"]; 
// Data yang ditampilkan diambil dari $_SESSION["user"] yang diset di process_login.php

// Anda bisa menambahkan logika untuk mengambil data user yang lebih lengkap
// dari database di sini jika diperlukan (misal: alamat, no. telepon)
// require "conn.php";
// $stmt = $mysqli->prepare("SELECT ... FROM users WHERE id = ?");
// $stmt->bind_param("i", $current_user['id']); 
// ...
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Profile - GM'Mart</title>
    
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        function toggleMenu() {
            document.querySelector(".nav-menu").classList.toggle("active");
        }
    </script>
</head>
<body>

<header class="navbar">
    <div class="logo-title">
        <img src="Logo.jpg" class="logo">
        <h1 class="brand"><span class="cyan">GM'</span>Mart</h1>
    </div>
    <div class="menu-toggle" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <nav class="nav-menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php" class="active-link">Profile</a> <a href="market.php">Market</a> 
        <a href="tracking.php">Tracking</a>
        <a href="History.php">History</a>
    </nav>
    <form action="Logout.php" method="POST">
        <button class="logout">Log out</button>
    </form>
</header>

<main class="main-content">
    
    <h2 class="page-title">Profil Pengguna</h2>

    <div class="profile-card">
        <h3>Detail Akun</h3>
        <p><strong>ID Pengguna:</strong> <?= htmlspecialchars($current_user["id"] ?? 'N/A') ?></p>
        <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($current_user["nama"]) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($current_user["email"]) ?></p>
        </div>

</main>

<footer class="footer">
    © 2025 <span>GM'Mart</span>. All rights reserved.
</footer>

</body>
</html>
