<?php
// FILE: admin_manage_users.php
session_start();
require "conn.php"; 

// --- CEK LOGIN ADMIN ---
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== 'admin') {
    header("Location: Login.php"); 
    exit;
}

$current_user = $_SESSION["user"];
$message = '';
$error = '';

// ---------------------------------------------------
// CEK TABEL ADA / TIDAK
// ---------------------------------------------------
function table_exists($mysqli, $table) {
    $q = $mysqli->query("SHOW TABLES LIKE '$table'");
    return ($q && $q->num_rows > 0);
}

// ---------------------------------------------------
// CEK KOLOM ADA / TIDAK
// ---------------------------------------------------
function column_exists($mysqli, $table, $column) {
    if (!table_exists($mysqli, $table)) return false;
    $q = $mysqli->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    return ($q && $q->num_rows > 0);
}

// ---------------------------------------------------
// HANDLE UPDATE ROLE
// ---------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'], $_POST['new_role'])) {

    if (!table_exists($mysqli, "users") || !column_exists($mysqli, "users", "role")) {
        $error = "Struktur tabel users tidak lengkap.";
    } else {
        $user_id = (int)$_POST['user_id'];
        $new_role = $_POST['new_role'];

        $valid_roles = ['customer', 'seller', 'admin'];
        if (!in_array($new_role, $valid_roles)) {
            $error = "Role tidak valid.";
        } else {
            $mysqli->query("UPDATE users SET role='$new_role', store_id=NULL WHERE id=$user_id");
            header("Location: admin_manage_users.php?msg=Role berhasil diperbarui");
            exit;
        }
    }
}

// ---------------------------------------------------
// AMBIL SEMUA USER DENGAN ANTI ERROR
// ---------------------------------------------------
$users = [];

if (table_exists($mysqli, "users")) {

    $columns = [
        "id",
        column_exists($mysqli, "users", "nama") ? "nama" : "'' AS nama",
        column_exists($mysqli, "users", "email") ? "email" : "'' AS email",
        column_exists($mysqli, "users", "role") ? "role" : "'customer' AS role",
        column_exists($mysqli, "users", "store_id") ? "store_id" : "NULL AS store_id"
    ];

    $sql = "SELECT " . implode(", ", $columns) . " FROM users ORDER BY id ASC";
    $result = $mysqli->query($sql);

    if ($result) {
        $users = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// ---------------------------------------------------
// AMBIL INFO TOKO (HANYA JIKA ADA TABELNYA)
// ---------------------------------------------------
$store_data = [];

if (table_exists($mysqli, "stores")) {
    $sql_store = "
        SELECT 
            id,
            " . (column_exists($mysqli, "stores", "store_name") ? "store_name" : "'' AS store_name") . ",
            " . (column_exists($mysqli, "stores", "store_status") ? "store_status" : "'pending' AS store_status") . ",
            " . (column_exists($mysqli, "stores", "seller_id") ? "seller_id" : "0 AS seller_id") . "
        FROM stores
    ";

    $res_store = $mysqli->query($sql_store);
    if ($res_store) {
        while ($row = $res_store->fetch_assoc()) {
            $store_data[$row['seller_id']] = $row;
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
    <title>Manajemen Pengguna - GM'Mart Admin</title>

    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="admin.css">
</head>

<body>

<header class="navbar">
    <div class="logo-title">
        <img src="Logo.jpg" class="logo">
        <h1 class="brand"><span class="cyan">GM'</span>Mart - ADMIN</h1>
    </div>

    <nav class="nav-menu">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="admin_manage_users.php" class="active-link">Manajemen Pengguna</a>
        <a href="admin_manage_stores.php">Verifikasi Toko</a>
    </nav>

    <form action="Logout.php" method="POST">
        <button class="logout">Log out</button>
    </form>
</header>

<main class="main-content">
    <h2 class="page-title">Manajemen Pengguna</h2>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert success"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <section class="user-list">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Nama Toko</th>
                    <th>Status Toko</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($users as $u): ?>
                    <?php 
                        $store = $store_data[$u['id']] ?? null;
                    ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['nama']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['role']) ?></td>

                        <td><?= $store['store_name'] ?? '-' ?></td>
                        <td><?= $store['store_status'] ?? '-' ?></td>

                        <td>
                            <form method="POST">
                                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">

                                <select name="new_role">
                                    <option value="customer" <?= $u['role']=='customer'?'selected':'' ?>>Customer</option>
                                    <option value="seller" <?= $u['role']=='seller'?'selected':'' ?>>Seller</option>
                                    <option value="admin" <?= $u['role']=='admin'?'selected':'' ?>>Admin</option>
                                </select>

                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
</main>
<footer class="footer">
    © 2025 GM'Mart. Admin Panel.
</footer>

</body>
</html>
