<?php
// FILE: profile.php
session_start();

// CEK LOGIN
if (!isset($_SESSION["user"])) {
    header("Location: Login.php"); 
    exit;
}

// Data user (Simulasi data yang seharusnya diambil dari DB atau process_login)
$current_user = $_SESSION["user"] ?? ['id' => '1001', 'nama' => 'Pengguna GM', 'email' => 'user@gmmart.com']; 
$current_user['tanggal_join'] = $current_user['tanggal_join'] ?? '2023-01-01';
$current_user['alamat'] = $current_user['alamat'] ?? 'Jl. Merdeka No. 17, Jakarta';

$cart_count = count($_SESSION['cart'] ?? []);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Profile - GM'Mart</title>
    
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="profile.css"> <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
        <div></div> <div></div> <div></div>
    </div>
    <nav class="nav-menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php" class="active-link">Profile</a> 
        <a href="market.php">Market</a> 
        <a href="tracking.php">Tracking</a>
        <a href="History.php">History</a>
        <a href="cart.php">Cart (<?= $cart_count ?>)</a>
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
        <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($current_user["nama"] ?? 'N/A') ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($current_user["email"] ?? 'N/A') ?></p>
        <p><strong>Tanggal Bergabung:</strong> <?= htmlspecialchars($current_user["tanggal_join"] ?? 'N/A') ?></p>
        <p><strong>Alamat:</strong> <?= htmlspecialchars($current_user["alamat"] ?? 'N/A') ?></p>
    </div>
</main>

<footer class="footer">
    © 2025 GM'Mart. All rights reserved.
</footer>

</body>
</html>