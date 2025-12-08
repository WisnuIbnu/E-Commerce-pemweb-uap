// FILE: cart.php
<?php
session_start();
// CEK LOGIN
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
$current_user = $_SESSION["user"]; 
// Data Keranjang (Simulasi Session Cart)
$cart_items = $_SESSION['cart'] ?? []; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Keranjang - GM'Mart</title>
    
    <link rel="stylesheet" href="dashboard.css">
    <style> /* CSS Sederhana untuk Cart */
        .cart-list { max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .cart-item { display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #eee; padding: 10px 0; }
        .cart-item img { width: 60px; height: 60px; object-fit: cover; margin-right: 15px; }
        .item-info { flex-grow: 1; }
        .checkout-btn { background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px; float: right; }
    </style>
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
        <a href="profile.php">Profile</a>
        <a href="market.php">Market</a>
        <a href="tracking.php">Tracking</a>
        <a href="History.php">History</a>
        <a href="cart.php" class="active-link">Cart (<?= count($cart_items) ?>)</a> </nav>
    <form action="Logout.php" method="POST">
        <button class="logout">Log out</button>
    </form>
</header>

<main class="main-content">
    <h2 class="page-title">Keranjang Pemesanan</h2>
    <div class="cart-list">
        <?php if (!empty($cart_items)): ?>
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <div class="item-info">
                        <h4><?= htmlspecialchars($item['name']); ?></h4>
                        <p>Jumlah: <?= htmlspecialchars($item['quantity']); ?> x Rp <?= htmlspecialchars($item['price']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <button class="checkout-btn">Lanjut ke Pembayaran</button>
        <?php else: ?>
            <p style="text-align: center;">Keranjang Anda kosong. Yuk, belanja!</p>
        <?php endif; ?>
    </div>
</main>

<footer class="footer">
    © 2025 <span>GM'Mart</span>. All rights reserved.
</footer>
</body>
</html>
