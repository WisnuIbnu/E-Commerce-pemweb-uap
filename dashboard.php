<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$current_user = $_SESSION["user"];
$role = $current_user["role"] ?? "customer";

if ($role === "admin") {
    header("Location: admin_dashboard.php");
    exit;
}

if ($role === "seller") {
    header("Location: seller_dashboard.php");
    exit;
}

$flash_sale_product = [
    "id" => 9, 
    "image" => "Gaming mouse.jpg", 
    "name" => "Gaming Mouse X99", 
    "original_price" => "300.000", 
    "discounted_price" => "199.000",
    "discount" => "34%"
];

$flash_sale_end_date = "15-12-2025 / 18:00 WIB";

$discount_products = [
    ["id" => 10, "image" => "headphone.jpg", "name" => "Headset PRO-1", "original_price" => "650.000", "discounted_price" => "499.000"],
    ["id" => 12, "image" => "keyboard.jpg", "name" => "Keyboard Mini RGB", "original_price" => "400.000", "discounted_price" => "250.000"],
];

$cart_count = count($_SESSION['cart'] ?? []);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GM'Mart Dashboard</title>
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

    <section class="hero">
        <div class="hero-content">
            <div class="hero-image">
                <img src="dashboard.jpg" alt="Dashboard GM'Mart">
            </div>
            <div class="hero-text">
                <h1>Halo, <?= htmlspecialchars($current_user["nama"]) ?>!</h1>
                <p>Selamat datang di <span class="gm">GM'Mart</span> — tempat terbaik untuk kebutuhan teknologi Anda!</p>
            </div>
        </div>
    </section>

    <section class="flash-sale">
        <h2>🔥 Flash Sale Hari Ini!</h2>
        <p class="sale-timer">Berakhir pada: <strong><?= htmlspecialchars($flash_sale_end_date) ?></strong></p>

        <div class="product-card featured">
            <div class="badge-discount"><?= $flash_sale_product['discount'] ?> OFF</div>
            <img src="<?= $flash_sale_product['image'] ?>" alt="<?= $flash_sale_product['name'] ?>">
            <h3><?= $flash_sale_product['name'] ?></h3>
            <p class="original-price">Rp <?= $flash_sale_product['original_price'] ?></p>
            <p class="discounted-price">Rp <?= $flash_sale_product['discounted_price'] ?></p>
            <a href="product_detail.php?id=<?= $flash_sale_product['id'] ?>" class="btn-buy">Beli Sekarang!</a>
        </div>
    </section>

    <section class="discount-products">
        <h2>Diskon Spesial untuk Anda</h2>

        <div class="product-grid">
            <?php foreach ($discount_products as $product): ?>
            <div class="product-card">
                <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                <h3><?= $product['name'] ?></h3>
                <p class="original-price">Rp <?= $product['original_price'] ?></p>
                <p class="discounted-price">Rp <?= $product['discounted_price'] ?></p>
                <a href="add_to_cart.php?id=<?= $product['id'] ?>" class="btn-cart">Add to Cart</a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

</main>

<footer class="footer">
    <p>&copy; 2025 GM'Mart. All rights reserved.</p>
</footer>

</body>
</html>
