<?php
// FILE: seller_dashboard.php
session_start();
require "conn.php"; // Pastikan koneksi DB tersedia

// CEK LOGIN DAN ROLE: Harus login dan memiliki role 'seller'
if (!isset($_SESSION["user"]) || ($_SESSION["user"]["role"] ?? 'customer') !== 'seller') {
    header("Location: Login.php"); 
    exit;
}

$current_user = $_SESSION["user"]; 
$store_id = $current_user['store_id'];
$cart_count = count($_SESSION['cart'] ?? []);

$store_status = 'new_user'; // Default state

if ($store_id) {
    // Jika user punya store_id, cek status toko di database
    $stmt = $mysqli->prepare("SELECT store_name, store_status FROM stores WHERE id = ?");
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $store = $result->fetch_assoc();
    $stmt->close();
    
    if ($store) {
        $store_status = $store['store_status']; // 'pending', 'verified', or 'rejected'
        $store_name = $store['store_name'];
    }
}

// --- LOGIKA STATS PENJUAL (SIMULASI) ---
// Pada implementasi penuh, data ini diambil berdasarkan store_id
$total_products = 0;
$pending_orders = 0;
$current_balance = "0";

if ($store_status == 'verified') {
    // Contoh: Ambil jumlah produk yang dijual toko ini
    $stmt_prod = $mysqli->prepare("SELECT COUNT(*) FROM products WHERE store_id = ? AND is_deleted = 0");
    $stmt_prod->bind_param("i", $store_id);
    $stmt_prod->execute();
    $total_products = $stmt_prod->get_result()->fetch_row()[0] ?? 0;
    $stmt_prod->close();
    
    // Contoh: Ambil saldo saat ini
    $stmt_bal = $mysqli->prepare("SELECT current_balance FROM seller_balances WHERE store_id = ?");
    $stmt_bal->bind_param("i", $store_id);
    $stmt_bal->execute();
    $current_balance = number_format($stmt_bal->get_result()->fetch_row()[0] ?? 0, 0, ',', '.');
    $stmt_bal->close();

    // Contoh: Ambil jumlah pesanan baru/processing
    // Note: Anda harus query tabel order_items
    $pending_orders = 5; 
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Seller Dashboard - GM'Mart</title>
    
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="seller.css"> 
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
        <h1 class="brand"><span class="cyan">GM'</span>Mart - SELLER</h1>
    </div>
    <div class="menu-toggle" onclick="toggleMenu()">
        <div></div> <div></div> <div></div>
    </div>
    <nav class="nav-menu">
        <a href="seller_dashboard.php" class="active-link">Dashboard</a>
        <?php if ($store_status == 'verified'): ?>
            <a href="seller_manage_products.php">Kelola Produk</a>
            <a href="seller_manage_orders.php">Manajemen Pesanan</a>
            <a href="seller_balance.php">Saldo & Penarikan</a>
            <a href="seller_profile.php">Profil Toko</a>
        <?php endif; ?>
        <a href="dashboard.php" style="margin-left: 20px;">Ke Akun Pelanggan</a>
    </nav>
    <form action="Logout.php" method="POST">
        <button class="logout">Log out</button>
    </form>
</header>

<main class="main-content">
    <h2 class="page-title">Dasbor Penjual - <?= $store_status == 'verified' ? htmlspecialchars($store_name) : 'Status Toko' ?></h2>
    
    <?php if ($store_status == 'new_user' || $store_status == 'rejected'): ?>
        <div class="alert warning">
            <h3>Selamat Datang!</h3>
            <p>Untuk mulai berjualan, Anda perlu mendaftarkan toko Anda terlebih dahulu.</p>
            <a href="seller_register_store.php" class="btn-register-store">DAFTAR TOKO SEKARANG</a>
        </div>
    <?php elseif ($store_status == 'pending'): ?>
        <div class="alert info">
            <h3>Pendaftaran Toko Sedang Diproses</h3>
            <p>Toko Anda sedang dalam antrian verifikasi oleh Admin GM'Mart. Mohon tunggu, Anda akan diberitahu jika status sudah berubah.</p>
            <p>Status: **MENUNGGU VERIFIKASI**</p>
        </div>
    <?php elseif ($store_status == 'verified'): ?>
        <section class="seller-stats">
            <div class="stat-box seller-stat-box primary">
                <h3>Pesanan Baru</h3>
                <p><?= $pending_orders ?></p>
            </div>
        </section>

        <section class="seller-quick-links">
            <h2>Aksi Cepat</h2>
            <div class="link-grid">
                <a href="seller_products.php" class="quick-link">Kelola Produk & Stok</a>
                <a href="seller_orders.php" class="quick-link">Lihat Pesanan Baru</a>
                <a href="seller_withdrawal.php" class="quick-link">Minta Penarikan Dana</a>
            </div>
        </section>
    <?php endif; ?>

</main>

<footer class="footer">
    © 2025 GM'Mart. Seller Panel.
</footer>

</body>
</html>