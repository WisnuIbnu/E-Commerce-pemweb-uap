<?php
session_start();
require "conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Ambil data user berdasarkan email
    // Perbaikan: username digunakan sebagai 'nama'
    $stmt = $mysqli->prepare("
        SELECT id, username AS nama, email, password, role, store_id 
        FROM users 
        WHERE email = ?
    ");

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Validasi password
    if ($user && password_verify($password, $user["password"])) {

        // Simpan session user
        $_SESSION["user"] = [
            "id"        => $user["id"],
            "nama"      => $user["nama"],     // hasil alias dari username
            "email"     => $user["email"],
            "role"      => $user["role"],
            "store_id"  => $user["store_id"]
        ];

        // ROUTING BERDASARKAN ROLE
        if ($user["role"] === "admin") {
            header("Location: admin_dashboard.php");
            exit;
        } 
        elseif ($user["role"] === "seller") {
            header("Location: seller_dashboard.php");
            exit;
        } 
        else {
            header("Location: dashboard.php");
            exit;
        }
    }

    // Jika gagal login
    header("Location: Login.php?error=1");
    exit;
}

// Jika bukan POST
header("Location: Login.php");
exit;
?>
