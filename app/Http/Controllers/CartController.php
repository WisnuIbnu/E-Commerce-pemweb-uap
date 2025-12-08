<?php
// File: app/Controllers/CartController.php

class CartController
{
    private $productModel;

    public function __construct($productModel)
    {
        $this->productModel = $productModel;
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function index()
    {
        $cart_items = $_SESSION['cart'];
        require '../app/Views/cart/cart_view.php';
    }

    public function add()
    {
        // ... (Logika lengkap dari Langkah 8 untuk menambahkan/update cart dan redirect)
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /app.php/');
            return;
        }

        $product_id = $_POST['product_id'] ?? null;
        $qty = (int) ($_POST['qty'] ?? 1);
        $action = $_POST['action'] ?? 'add_to_cart';
        $product = $this->productModel->getProductForCart($product_id);

        if ($product && $qty > 0 && $qty <= $product['stock']) {
            $cart_id = $product['id'];

            if (isset($_SESSION['cart'][$cart_id])) {
                $_SESSION['cart'][$cart_id]['qty'] += $qty;
                $_SESSION['cart'][$cart_id]['subtotal'] = $_SESSION['cart'][$cart_id]['qty'] * $product['price'];
            } else {
                $_SESSION['cart'][$cart_id] = ['id' => $product['id'], 'name' => $product['name'], 'price' => $product['price'], 'qty' => $qty, 'subtotal' => $product['price'] * $qty];
            }

            if ($action === 'buy_now') {
                header('Location: /app.php/checkout');
            } else {
                $_SESSION['success'] = "Produk berhasil ditambahkan ke keranjang!";
                header('Location: /app.php/cart');
            }
            exit();
        } else {
            $_SESSION['error'] = "Produk tidak valid atau kuantitas melebihi stok.";
            header('Location: /app.php/product/' . $product_id);
            exit();
        }
    }

    public function remove($product_id)
    {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            $_SESSION['success'] = "Produk berhasil dihapus dari keranjang.";
        }
        header('Location: /app.php/cart');
        exit();
    }
}