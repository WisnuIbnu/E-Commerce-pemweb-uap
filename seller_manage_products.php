<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "seller") {
    header("Location: login.php");
    exit;
}

$current_user = $_SESSION["user"];
$store_id = $current_user["store_id"];
$products = [];

// Ambil produk jika tabel ada
if ($store_id && $mysqli->query("SHOW TABLES LIKE 'products'")->num_rows > 0) {
    $stmt = $mysqli->prepare("SELECT id, product_name, price, stock FROM products WHERE store_id = ?");
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk</title>
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
    <h1>Manajemen Produk</h1>
    <a href="seller_add_product.php" class="btn-primary">+ Tambah Produk Baru</a>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
                <tr><td colspan="5">Belum ada produk.</td></tr>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['product_name']) ?></td>
                        <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                        <td><?= $p['stock'] ?></td>
                        <td>
                            <a href="seller_edit_product.php?id=<?= $p['id'] ?>" class="btn-secondary">Edit</a>
                            <a href="seller_delete_product.php?id=<?= $p['id'] ?>" class="btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<footer>&copy; 2025 GM'Mart. Seller Panel.</footer>
</body>
</html>
