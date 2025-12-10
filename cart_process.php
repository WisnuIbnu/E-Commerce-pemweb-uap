<?php
// FILE: cart_process.php
session_start();

// Cek sesi login
if (!isset($_SESSION["user"])) {
    header("Location: Login.php"); 
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    
    // Data Produk Simulasi (Harus sinkron dengan market.php)
    $product_details = [
        1 => ["name" => "Keyboard Mekanik", "price" => "750.000"],
        2 => ["name" => "Monitor Gaming 24\"", "price" => "2.500.000"],
        3 => ["name" => "Prosesor i7 Terbaru", "price" => "4.200.000"],
        4 => ["name" => "Gaming Mouse", "price" => "150.000"],
        5 => ["name" => "Headset Gaming", "price" => "320.000"],
    ];

    if (isset($product_details[$product_id])) {
        $item = $product_details[$product_id];
        $item['id'] = $product_id;
        $item['quantity'] = 1;

        // Inisialisasi keranjang jika belum ada
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Tambahkan/update quantity
        $found = false;
        foreach ($_SESSION['cart'] as $key => $cart_item) {
            if ($cart_item['id'] === $product_id) {
                $_SESSION['cart'][$key]['quantity']++;
                $found = true;
                break;
            }
        }
        
        // Jika produk belum ada di keranjang, tambahkan
        if (!$found) {
            $_SESSION['cart'][] = $item;
        }

        // Redirect ke halaman keranjang setelah berhasil
        header("Location: cart.php"); 
        exit;
    }
}

// Redirect ke market jika diakses tanpa POST atau gagal
header("Location: market.php"); 
exit;
?>