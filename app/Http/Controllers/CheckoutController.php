<?php
// File: app/Controllers/CheckoutController.php

namespace App\Http\Controllers;

class CheckoutController
{
    private $transactionModel;

    public function __construct($transactionModel)
    {
        $this->transactionModel = $transactionModel;
    }

    private function getCurrentUserId()
    {
        // HARUS DIGANTI DENGAN LOGIKA AUTH ASLI
        return $_SESSION['user_id'] ?? 1; // Kembali ke User ID 1 (Opik Customer)
    }

    // Menampilkan form Checkout
    public function index()
    {
        $cart_items = $_SESSION['cart'] ?? [];

        if (empty($cart_items)) {
            $_SESSION['error'] = "Keranjang belanja kosong.";
            header('Location: /app.php/cart');
            exit();
        }

        $total_items_price = array_sum(array_column($cart_items, 'subtotal'));
        $shipping_cost = 15000;
        $grand_total = $total_items_price + $shipping_cost;

        $user_id = $this->getCurrentUserId();
        $buyer_info = $this->transactionModel->getBuyerInfo($user_id);

        require '../app/Views/checkout.php';
    }

    // Memproses pembayaran (Logika Langkah 10)
    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /app.php/checkout');
            return;
        }

        $user_id = $this->getCurrentUserId();
        $cart_items = $_SESSION['cart'] ?? [];

        if (empty($cart_items)) {
            header('Location: /app.php/cart');
            return;
        }

        // Minimal Validasi
        if (empty($_POST['address']) || empty($_POST['shipping_type'])) {
            $_SESSION['error'] = "Mohon lengkapi alamat dan tipe pengiriman.";
            header('Location: /app.php/checkout');
            return;
        }

        $shipping_cost = ($_POST['shipping_type'] == 'Express') ? 30000 : 15000;
        $form_data = [
            'address' => $_POST['address'],
            'city' => 'Malang',
            'postal_code' => '65141',
            'shipping_type' => $_POST['shipping_type'],
            'shipping_cost' => $shipping_cost,
            'payment_method' => $_POST['payment_method']
        ];
        $store_id = 1;

        try {
            $transaction_id = $this->transactionModel->createTransaction($user_id, $cart_items, $form_data, $store_id);

            unset($_SESSION['cart']);
            $_SESSION['success'] = "Pesanan berhasil dibuat! ID Transaksi: {$transaction_id}.";
            header("Location: /app.php/history?t_id=" . $transaction_id);
            exit();

        } catch (\Exception $e) {
            $_SESSION['error'] = "Checkout gagal: " . $e->getMessage();
            header("Location: /app.php/checkout");
            exit();
        }
    }
}