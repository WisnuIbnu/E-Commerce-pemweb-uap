<?php
// FILE: seller_profile.php
session_start();
require "conn.php"; 

// --- CEK LOGIN DAN ROLE SELLER ---
if (!isset($_SESSION["user"]) || ($_SESSION["user"]["role"] ?? 'customer') !== 'seller') {
    header("Location: Login.php"); 
    exit;
}

$current_user = $_SESSION["user"]; 
$active_page = 'profil_toko';

// SIMULASI DATA TOKO DARI DB
// Dalam nyata: $store_data = $mysqli->query("SELECT * FROM stores WHERE user_id = {$current_user['id']}")->fetch_assoc();
$store_data = [
    'store_name' => 'Toko Teknologi Jaya',
    'store_status' => 'Verified',
    'address' => 'Jl. Digital No. 45, Jakarta Barat',
    'phone' => '0812-3456-7890',
    'owner_name' => $current_user['nama'] ?? 'Budi',
    'join_date' => '2024-10-01',
];

$store_status_class = $store_data['store_status'] === 'Verified' ? 'completed' : 'pending-order';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Profil Toko - GM'Mart Seller</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="seller.css">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        function toggleMenu() { document.querySelector(".nav-menu").classList.toggle("active"); }
    </script>
</head>
<body>
<header class="navbar">
    <div class="logo-title">
        <img src="Logo.jpg" class="logo">
        <h1 class="brand"><span class="cyan">GM'</span>Mart - SELLER</h1>
    </div>
    <div class="menu-toggle" onclick="toggleMenu()">
        <div></div> <div></div> <div></div>
    </div>
    <nav class="nav-menu">
        <a href="seller_dashboard.php">Dashboard</a>
        <a href="seller_manage_products.php">Produk</a>
        <a href="seller_manage_orders.php">Pesanan</a>
        <a href="seller_balance.php">Saldo</a>
        <a href="seller_profile.php" class="active-link">Profil Toko</a>
        <a href="seller_to_customer.php" style="color: #ffc107;">Ke Akun Pelanggan</a>
    </nav>
    <form action="Logout.php" method="POST">
        <button class="logout">Log out</button>
    </form>
</header>

<main class="main-content">
    <h2 class="page-title">Profil Toko</h2>
    
    <div class="profile-card">
        <h3>Detail Toko</h3>
        <p><strong>Nama Toko:</strong> <?= htmlspecialchars($store_data['store_name']) ?></p>
        <p><strong>Status Verifikasi:</strong> 
            <span class="status-badge <?= $store_status_class ?>"><?= htmlspecialchars($store_data['store_status']) ?></span>
        </p>
        <p><strong>Alamat Toko:</strong> <?= htmlspecialchars($store_data['address']) ?></p>
        <p><strong>Nomor Telepon:</strong> <?= htmlspecialchars($store_data['phone']) ?></p>
        <p><strong>Tanggal Bergabung:</strong> <?= htmlspecialchars($store_data['join_date']) ?></p>
        
        <h3 style="margin-top: 30px;">Informasi Pemilik</h3>
        <p><strong>Nama Pemilik:</strong> <?= htmlspecialchars($store_data['owner_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($current_user['email'] ?? 'N/A') ?></p>
        
        <a href="seller_profile.php?action=edit" class="btn-primary" style="margin-top: 20px;">Edit Profil Toko</a>
    </div>

</main>

<footer class="footer">
    © 2025 GM'Mart. Seller Panel.
</footer>
</body>
</html>