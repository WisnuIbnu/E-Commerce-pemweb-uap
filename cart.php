<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$current_user = $_SESSION["user"];
$cart = $_SESSION['cart'] ?? [];
$cart_count = count($cart);
$total = 0;

// Dummy cart items
$cart_items = [
    ["id" => 1, "name" => "Gaming Mouse X99", "price" => "199.000", "qty" => 1, "image" => "Gaming mouse.jpg"],
    ["id" => 2, "name" => "Keyboard Mini RGB", "price" => "250.000", "qty" => 2, "image" => "keyboard.jpg"],
];

foreach ($cart_items as $item) {
    $total += (int)str_replace('.', '', $item['price']) * $item['qty'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - GM'Mart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>

<header class="navbar">
    <div class="logo-title">
        <img src="Logo.jpg" class="logo" alt="GM'Mart Logo">
        <h1 class="brand">GM'Mart</h1>
    </div>

    <nav class="nav-menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="market.php">Market</a>
        <a href="tracking.php">Tracking</a>
        <a href="History.php">History</a>
        <a href="cart.php">Cart (<?= $cart_count ?>)</a>
    </nav>

    <form action="Logout.php" method="POST" style="margin: 0;">
        <button type="submit" class="logout">Log out</button>
    </form>
</header>

<main class="main-content">
    <h1 style="color: #00FFE1; border-bottom: 2px solid #333; padding-bottom: 10px;">Keranjang Belanja</h1>

    <?php if (empty($cart_items)): ?>
        <p style="text-align: center; color: #bbb; margin: 40px 0;">Keranjang Anda kosong.</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <?php $subtotal = (int)str_replace('.', '', $item['price']) * $item['qty']; ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <img src="<?= $item['image'] ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                <span><?= htmlspecialchars($item['name']) ?></span>
                            </div>
                        </td>
                        <td>Rp <?= htmlspecialchars($item['price']) ?></td>
                        <td><?= $item['qty'] ?></td>
                        <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        <td><a href="remove_cart.php?id=<?= $item['id'] ?>" class="btn-danger">Hapus</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 30px;">
            <h2 style="color: #00FFE1;">Total: Rp <?= number_format($total, 0, ',', '.') ?></h2>
            <a href="checkout.php" class="btn-buy" style="display: inline-block; margin-top: 15px; padding: 12px 30px; font-size: 1.1em;">Checkout</a>
        </div>
    <?php endif; ?>
</main>

<footer class="footer">
    <p>&copy; 2025 GM'Mart. All rights reserved.</p>
</footer>

</body>
</html>
