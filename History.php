<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$current_user = $_SESSION["user"];
$cart_count = count($_SESSION['cart'] ?? []);

// Dummy history data
$history = [
    ["id" => "ORD001", "date" => "2025-12-01", "total" => "1.500.000", "status" => "Selesai"],
    ["id" => "ORD002", "date" => "2025-11-28", "total" => "850.000", "status" => "Selesai"],
    ["id" => "ORD003", "date" => "2025-11-20", "total" => "2.200.000", "status" => "Dibatalkan"],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - GM'Mart</title>

    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>

<!-- ================= NAVBAR ================= -->
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


<!-- ================= CONTENT ================= -->
<main class="main-content">

    <h1 style="
        color: #00FFE1; 
        border-bottom: 2px solid #333; 
        padding-bottom: 10px; 
        margin-bottom: 25px;
    ">
        Riwayat Pesanan
    </h1>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            <?php if (empty($history)): ?>
                <tr>
                    <td colspan="4" style="text-align:center;">Belum ada riwayat pesanan.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($history as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['date']) ?></td>
                        <td>Rp <?= htmlspecialchars($order['total']) ?></td>
                        <td>
                            <span class="status-badge <?= strtolower($order['status']) ?>">
                                <?= htmlspecialchars($order['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</main>


<!-- ================= FOOTER ================= -->
<footer class="footer">
    <p>&copy; 2025 GM'Mart. All rights reserved.</p>
</footer>

</body>
</html>
