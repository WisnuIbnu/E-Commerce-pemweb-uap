<?php
// FILE: cart.php
session_start();
// CEK LOGIN
if (!isset($_SESSION["user"])) {
    header("Location: Login.php"); 
    exit;
}
$current_user = $_SESSION["user"]; 
// Data Keranjang (Ambil dari Session Cart)
$cart_items = $_SESSION['cart'] ?? []; 
$cart_count = count($cart_items);

// BARU: Inisialisasi dan Hitung Total Harga
$total_price = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Keranjang - GM'Mart</title>
    
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="cart.css"> <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
        <a href="profile.php">Profile</a>
        <a href="market.php">Market</a>
        <a href="tracking.php">Tracking</a>
        <a href="History.php">History</a>
        <a href="cart.php" class="active-link">Cart (<?= $cart_count ?>)</a> 
    </nav>
    <form action="Logout.php" method="POST">
        <button class="logout">Log out</button>
    </form>
</header>

<main class="main-content">
    <h2 class="page-title">Keranjang Pemesanan</h2>
    <div class="cart-list">
        <?php if (!empty($cart_items)): ?>
            <?php foreach ($cart_items as $item): 
                $clean_price = str_replace('.', '', $item['price']);
                $subtotal = (int)$clean_price * (int)$item['quantity'];
                // BARU: Akumulasi total
                $total_price += $subtotal;
            ?>
                <div class="cart-item">
                    <div class="item-info">
                        <h4><?= htmlspecialchars($item['name']); ?></h4>
                        <p>Jumlah: <?= htmlspecialchars($item['quantity']); ?> | Harga Satuan: Rp <?= htmlspecialchars($item['price']); ?></p>
                        <p>Subtotal: Rp <?= number_format($subtotal, 0, ',', '.'); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="cart-summary" style="margin-top: 20px; text-align: right; font-size: 1.3em; color: #00FFE1;">
                <strong>TOTAL HARGA BARANG: Rp <?= number_format($total_price, 0, ',', '.'); ?></strong>
            </div>

            <form action="checkout.php" method="POST">
                <button type="submit" class="checkout-btn">Lanjut ke Pembayaran</button>
            </form>

        <?php else: ?>
            <p style="text-align: center;">Keranjang Anda kosong. Yuk, belanja!</p>
        <?php endif; ?>
    </div>
</main>

<footer class="footer">
    © 2025 GM'Mart. All rights reserved.
</footer>

</body>
</html>