<?php
// FILE: seller_register_store.php
session_start();
require "conn.php"; 

// CEK LOGIN DAN ROLE: Hanya customer atau seller tanpa store_id yang diizinkan (role 'seller' awal)
if (!isset($_SESSION["user"])) {
    header("Location: Login.php"); 
    exit;
}

$current_user = $_SESSION["user"]; 
$user_id = $current_user['id'];
$cart_count = count($_SESSION['cart'] ?? []);
$message = '';
$error = '';

// Cek status toko saat ini
$existing_store = null;
if (isset($current_user['store_id']) && $current_user['store_id']) {
    $stmt = $mysqli->prepare("SELECT id, store_status FROM stores WHERE id = ?");
    $stmt->bind_param("i", $current_user['store_id']);
    $stmt->execute();
    $existing_store = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_store'])) {
    $store_name = trim($_POST['store_name']);
    $store_description = trim($_POST['store_description']);

    if (empty($store_name)) {
        $error = "Nama toko tidak boleh kosong.";
    } else {
        // Cek apakah user ini sudah pernah mengajukan pendaftaran
        if ($existing_store && $existing_store['store_status'] == 'pending') {
            $error = "Anda sudah memiliki toko yang sedang menunggu verifikasi.";
        } else {
            // Jika toko ditolak atau belum pernah ada, buat pendaftaran baru
            
            // 1. Masukkan data toko ke tabel stores (status 'pending')
            $stmt = $mysqli->prepare("INSERT INTO stores (seller_id, store_name, store_description) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $store_name, $store_description);
            $stmt->execute();
            $new_store_id = $mysqli->insert_id;
            $stmt->close();

            if ($new_store_id) {
                // 2. Update role user menjadi 'seller' dan simpan store_id di tabel users
                $stmt_user = $mysqli->prepare("UPDATE users SET role = 'seller', store_id = ? WHERE id = ?");
                $stmt_user->bind_param("ii", $new_store_id, $user_id);
                $stmt_user->execute();
                $stmt_user->close();
                
                // 3. Update SESSION
                $_SESSION['user']['role'] = 'seller';
                $_SESSION['user']['store_id'] = $new_store_id;

                // 4. Inisialisasi saldo toko di tabel seller_balances
                $stmt_balance = $mysqli->prepare("INSERT INTO seller_balances (store_id, current_balance) VALUES (?, 0.00)");
                $stmt_balance->bind_param("i", $new_store_id);
                $stmt_balance->execute();
                $stmt_balance->close();

                header("Location: seller_dashboard.php?msg=" . urlencode("Pendaftaran toko berhasil diajukan. Menunggu verifikasi Admin."));
                exit;
            } else {
                $error = "Gagal menyimpan data toko ke database.";
            }
        }
    }
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Daftar Toko - GM'Mart Seller</title>
    
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="seller.css"> 
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
        <h1 class="brand"><span class="cyan">GM'</span>Mart - SELLER</h1>
    </div>
    <div class="menu-toggle" onclick="toggleMenu()">
        <div></div> <div></div> <div></div>
    </div>
    <nav class="nav-menu">
        <a href="seller_dashboard.php" class="active-link">Dashboard</a>
        <a href="dashboard.php" style="margin-left: 20px;">Ke Akun Pelanggan</a>
    </nav>
    <form action="Logout.php" method="POST">
        <button class="logout">Log out</button>
    </form>
</header>

<main class="main-content">
    <h2 class="page-title">Pendaftaran Toko Baru</h2>
    
    <?php if ($error): ?>
        <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($existing_store && $existing_store['store_status'] == 'pending'): ?>
        <div class="alert info">
            <p>Anda sudah memiliki aplikasi toko yang sedang **MENUNGGU VERIFIKASI**.</p>
        </div>
    <?php elseif ($existing_store && $existing_store['store_status'] == 'verified'): ?>
        <div class="alert success">
            <p>Toko Anda sudah **TERVERIFIKASI**. Silakan kembali ke <a href="seller_dashboard.php">Dasbor Penjual</a>.</p>
        </div>
    <?php else: ?>
        <div class="form-container">
            <h3>Lengkapi Detail Toko Anda</h3>
            <form method="POST">
                <div class="form-group">
                    <label for="store_name">Nama Toko:</label>
                    <input type="text" id="store_name" name="store_name" required>
                </div>
                <div class="form-group">
                    <label for="store_description">Deskripsi Toko:</label>
                    <textarea id="store_description" name="store_description" rows="4"></textarea>
                </div>
                <button type="submit" name="register_store" class="btn-submit">Ajukan Pendaftaran</button>
            </form>
        </div>
    <?php endif; ?>
</main>

<footer class="footer">
    © 2025 GM'Mart. Seller Panel.
</footer>

</body>
</html>