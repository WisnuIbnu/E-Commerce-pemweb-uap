<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "seller") {
    header("Location: login.php");
    exit;
}

$orders = []; // Dummy untuk sekarang
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Pesanan</title>
    <link rel="stylesheet" href="seller.css">
</head>
<body>
<nav>
    <h2>GM'Mart - SELLER</h2>
    <div>
        <a href="seller_dashboard.php">Dashboard</a>
        <a href="seller_manage_products.php">Produk</a>
        <a href="seller_manage_orders.php">Pesanan</a>
        <a href="seller_balance.php">Saldo</a>
        <a href="logout.php">Log out</a>
    </div>
</nav>

<main>
    <h1>Manajemen Pesanan</h1>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="5">Belum ada pesanan masuk.</td></tr>
        </tbody>
    </table>
</main>

<footer>&copy; 2025 GM'Mart. Seller Panel.</footer>
</body>
</html>
