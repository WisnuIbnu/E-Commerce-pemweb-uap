<?php
// FILE: dashboard.php
session_start();

// CEK LOGIN: Jika session user tidak ada, redirect ke login
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// Data user yang sedang login
$current_user = $_SESSION["user"]; 
$role = $current_user['role'] ?? 'customer'; // Ambil role user

// PENGALIHAN BERDASARKAN ROLE (ROUTER)
if ($role == 'admin') {
    header("Location: admin_dashboard.php");
    exit;
} elseif ($role == 'seller') {
    // Penjual diarahkan ke dashboard khusus penjual
    header("Location: seller_dashboard.php");
    exit;
}

// --- LOGIKA UNTUK CUSTOMER (Pelanggan Biasa) ---

// Data produk untuk Flash Sale & Diskon (DUMMY DATA)
$flash_sale_product = [
    "id" => 9, 
    "image" => "Gaming mouse.jpg", 
    "name" => "Gaming Mouse X99", 
    "original_price" => "300.000", 
    "discounted_price" => "199.000",
    "discount" => "34%"
];

// PERUBAHAN DI SINI: Menambahkan slash (/) setelah tahun
$flash_sale_end_date = "15-12-2025/ 18:00 WIB"; 

$discount_products = [
    ["id" => 10, "image" => "headphone.jpg", "name" => "Headset PRO-1", "original_price" => "650.000", "discounted_price" => "499.000"],

    ["id" => 12, "image" => "keyboard.jpg", "name" => "Keyboard Mini RGB", "original_price" => "400.000", "discounted_price" => "250.000"],
];

// Asumsi cart count
$cart_count = count($_SESSION['cart'] ?? []);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>GM'Mart Dashboard</title>

    <link rel="stylesheet" href="dashboard.css">

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
        <a href="cart.php">Cart (<?= $cart_count ?>)</a>
    </nav>

    <form action="Logout.php" method="POST">
        <button class="logout">Log out</button>
    </form>
</header>

<main class="main-content">

    <section class="hero">
        <div class="hero-left"></div>
        <div class="hero-right"></div>

        <div class="hero-content">
            <h1>Halo, <?= htmlspecialchars($current_user["nama"] ?? 'Pengguna') ?>!</h1> 
            <p>Selamat Datang di <span>GM'Mart</span> — tempat terbaik untuk kebutuhan teknologi Anda!</p>
        </div>
    </section>

    </section>

    <section class="flash-sale">
        <div class="section-header">
            <h2>🔥 Flash Sale Hari Ini!</h2>
            <div class="flash-sale-timer">
                <p>Berakhir pada: <span class="end-date"><?= htmlspecialchars($flash_sale_end_date) ?></span></p>
            </div>
        </div>

        <div class="product-grid flash-grid">
            <div class="product-card">
                <img src="<?= htmlspecialchars($flash_sale_product['image']); ?>" alt="<?= htmlspecialchars($flash_sale_product['name']); ?>">
                <div class="discount-badge"><?= $flash_sale_product['discount'] ?> OFF</div>
                <h3><?= htmlspecialchars($flash_sale_product['name']); ?></h3>
                <p class="original-price">Rp <?= $flash_sale_product['original_price']; ?></p>
                <p class="discounted-price">Rp <?= $flash_sale_product['discounted_price']; ?></p>
                <form action="cart_process.php" method="POST"> 
                    <input type="hidden" name="product_id" value="<?= $flash_sale_product['id']; ?>">
                    <button type="submit" name="add_to_cart" class="btn-add-cart">Beli Sekarang!</button>
                </form>
            </div>
        </div>
    </section>

    <section class="discount-products">
        <div class="section-header">
            <h2>Diskon Spesial untuk Anda</h2>
            <a href="market.php?category=discount" class="see-all-link">Lihat Semua ></a>
        </div>
        <div class="product-grid">
            <?php foreach ($discount_products as $product): ?>
            <div class="product-card">
                <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                <h3><?= htmlspecialchars($product['name']); ?></h3>
                <p class="original-price">Rp <?= $product['original_price']; ?></p>
                <p class="discounted-price">Rp <?= $product['discounted_price']; ?></p>
                <form action="cart_process.php" method="POST"> 
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <button type="submit" name="add_to_cart" class="btn-add-cart">Add to Cart</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

</main> 

<footer class="footer">
    © 2025 <span>GM'Mart</span>. All rights reserved.
</footer>

</body>
</html>
