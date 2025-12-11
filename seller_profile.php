<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "seller") {
    header("Location: login.php");
    exit;
}

$current_user = $_SESSION["user"];
$store_id = $current_user["store_id"];
$store_data = ['store_name' => 'Belum ada toko', 'store_status' => 'pending'];

if ($store_id) {
    $stmt = $mysqli->prepare("SELECT store_name, store_status, created_at FROM stores WHERE id = ?");
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    if ($res) $store_data = $res;
    $stmt->close();
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Toko</title>
    <link rel="stylesheet" href="seller.css">
</head>
<body>
<nav>
    <h2>GM'Mart - SELLER</h2>
    <div>
        <a href="seller_dashboard.php">Dashboard</a>
        <a href="seller_manage_products.php">Produk</a>
        <a href="seller_profile.php">Profil Toko</a>
        <a href="logout.php">Log out</a>
    </div>
</nav>

<main>
    <h1>Profil Toko</h1>

    <div class="profile-card">
        <h3>Detail Toko</h3>
        <p><strong>Nama Toko:</strong> <?= htmlspecialchars($store_data['store_name']) ?></p>
        <p><strong>Status:</strong> <span class="status-badge <?= $store_data['store_status'] === 'active' ? 'active' : 'pending-order' ?>"><?= strtoupper($store_data['store_status']) ?></span></p>
        
        <h3>Informasi Pemilik</h3>
        <p><strong>Nama:</strong> <?= htmlspecialchars($current_user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($current_user['email']) ?></p>
    </div>
</main>

<footer>&copy; 2025 GM'Mart. Seller Panel.</footer>
</body>
</html>
