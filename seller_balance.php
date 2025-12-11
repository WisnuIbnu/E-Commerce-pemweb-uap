<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "seller") {
    header("Location: login.php");
    exit;
}

$current_user = $_SESSION["user"];
$store_id = $current_user["store_id"];
$current_balance = 0;
$minimum_withdrawal = 50000;

if ($store_id && $mysqli->query("SHOW TABLES LIKE 'seller_balances'")->num_rows > 0) {
    $stmt = $mysqli->prepare("SELECT current_balance FROM seller_balances WHERE store_id = ?");
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    $current_balance = $stmt->get_result()->fetch_row()[0] ?? 0;
    $stmt->close();
}

$withdrawal_history = [];
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Saldo & Penarikan</title>
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
        <a href="seller_profile.php">Profil Toko</a>
        <a href="logout.php">Log out</a>
    </div>
</nav>

<main>
    <h1>Saldo dan Penarikan Dana</h1>

    <div class="balance-card">
        <div class="current-balance">
            <h3>Saldo Tersedia</h3>
            <p>Rp <?= number_format($current_balance, 0, ',', '.') ?></p>
        </div>

        <h3>Ajukan Penarikan</h3>
        <p>Minimum penarikan: <strong>Rp <?= number_format($minimum_withdrawal, 0, ',', '.') ?></strong></p>

        <form method="POST">
            <div class="form-group">
                <label>Jumlah Penarikan (Rp):</label>
                <input type="number" name="amount" min="<?= $minimum_withdrawal ?>" required>
            </div>
            <button type="submit" name="withdraw" class="withdraw-button">Tarik Dana Sekarang</button>
        </form>
    </div>

    <h2>Riwayat Penarikan Dana</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($withdrawal_history)): ?>
                <tr><td colspan="3">Belum ada riwayat penarikan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<footer>
    <p>&copy; 2025 GM'Mart. Seller Panel.</p>
</footer>
</body>
</html>
