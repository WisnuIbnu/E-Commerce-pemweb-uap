<?php
// FILE: process_login.php - Harap diletakkan di root
session_start();
require "conn.php"; // Pastikan path ke file koneksi Anda benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // PERUBAHAN UTAMA: Mengambil kolom 'role' dan 'store_id'
    $stmt = $mysqli->prepare("SELECT id, nama, email, password, role, store_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    
    // Asumsi: $mysqli tidak ditutup di sini jika Anda menggunakannya lagi di halaman lain

    if ($user && password_verify($password, $user["password"])) {
        
        // Simpan data lengkap user ke sesi
        $_SESSION["user"] = [
            'id' => $user['id'],
            'nama' => $user['nama'],
            'email' => $user['email'],
            'role' => $user['role'],         // <= BARU
            'store_id' => $user['store_id'], // <= BARU
            // Anda mungkin perlu menambahkan 'tanggal_join' dan 'alamat' jika ada di tabel users
        ];
        
        // Pengalihan sekarang dilakukan di dashboard.php (lihat kode di bawah)
        header("Location: dashboard.php"); 
        exit;
        
    } else {
        header("Location: Login.php?error=1"); 
        exit;
    }
} else {
    header("Location: Login.php"); 
    exit;
}
?>