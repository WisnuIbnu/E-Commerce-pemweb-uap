<?php
// FILE: History.php
session_start();

// CEK LOGIN
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
$current_user = $_SESSION["user"]; // Data user login
// ... [Dummy data history tetap sama]
$history = [
    [
        "image" => "Gaming mouse.jpg",
        "product" => "Gaming Mouse",
        "price" => "150.000",
        "quantity" => 1
    ],
    [
        "image" => "headset.jpg",
        "product" => "Headset Gaming",
        "price" => "320.000",
        "quantity" => 1
    ]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>History - GM'Mart</title>
    
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="history.css"> 
    
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
        <a href="#">Profile</a>
        <a href="#">Market</a>
        <a href="#">Tracking</a>
        <a href="History.php" class="active-link">History</a>
    </nav>
    <form action="Logout.php" method="POST">
        <button class="logout">Log out</button>
    </form>
</header>

<main class="main-content">
    
    <h2 class="page-title">Riwayat Transaksi</h2>

    <div class="history-container">
        <?php foreach ($history as $item): ?>
            <div class="history-card">
                <img src="<?= htmlspecialchars($item['image']); ?>" alt="Product Image">
                <div class="history-info">
                    <h3><?= htmlspecialchars($item['product']); ?></h3>
                    <p><strong>Harga:</strong> Rp <?= htmlspecialchars($item['price']); ?></p>
                    <p><strong>Quantity:</strong> <?= htmlspecialchars($item['quantity']); ?></p>
                    <p class="success-msg">Terima Kasih, produk berhasil dipesan!!</p>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($history)): ?>
            <p class="empty-msg">Belum ada riwayat transaksi.</p>
        <?php endif; ?>

    </div>

</main>

<footer class="footer">
    © 2025 <span>GM'Mart</span>. All rights reserved.
</footer>

</body>
</html>
