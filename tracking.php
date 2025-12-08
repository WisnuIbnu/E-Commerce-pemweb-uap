// FILE: tracking.php
<?php
session_start();
// CEK LOGIN
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
// Data dummy status pesanan
$orders = [
    ["id" => "TRX001", "product" => "Keyboard Mekanik", "status" => "Dalam Pengiriman", "date" => "2025-12-05"],
    ["id" => "TRX002", "product" => "Monitor Gaming 24\"", "status" => "Diproses", "date" => "2025-12-06"],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Tracking - GM'Mart</title>
    
    <link rel="stylesheet" href="dashboard.css">
    <style> /* CSS Sederhana untuk Tracking */
        .order-list { max-width: 900px; margin: 20px auto; padding: 20px; }
        .order-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; }
        .status-msg { font-weight: bold; color: #00bcd4; }
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
        <a href="tracking.php" class="active-link">Tracking</a> <a href="History.php">History</a>
    </nav>
    <form action="Logout.php" method="POST">
        <button class="logout">Log out</button>
    </form>
</header>

<main class="main-content">
    <h2 class="page-title">Lacak Pesanan</h2>
    <div class="order-list">
        <?php foreach ($orders as $order): ?>
            <div class="order-card">
                <h4>Pesanan ID: <?= htmlspecialchars($order['id']); ?></h4>
                <p>Produk: <?= htmlspecialchars($order['product']); ?></p>
                <p>Tanggal Pesan: <?= htmlspecialchars($order['date']); ?></p>
                <p>Status: <span class="status-msg"><?= htmlspecialchars($order['status']); ?></span></p>
                <?php if ($order['status'] == 'Dalam Pengiriman'): ?>
                    <p style="font-size: small;">Estimasi tiba 2 hari lagi.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <?php if (empty($orders)): ?>
            <p class="empty-msg">Tidak ada pesanan yang sedang diproses.</p>
        <?php endif; ?>
    </div>
</main>

<footer class="footer">
    © 2025 <span>GM'Mart</span>. All rights reserved.
</footer>
</body>
</html>
