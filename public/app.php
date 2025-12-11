<?php
// File: public/app.php (Perbaikan Jalur Absolut)

session_start(); 

// --- DEFINISI JALUR DASAR (BASE PATH) ---
// dirname(__DIR__) akan menghasilkan: C:\laragon\www\E-Commerce-pemweb-uap-group1
define('ROOT_PATH', dirname(__DIR__)); 

// --- 1. Panggil Semua Model & Controller (MENGGUNAKAN JALUR ABSOLUT) ---
// Ganti semua require '../app/...' dengan require ROOT_PATH . '/app/...'

// Baris 13 (yang error) dan baris berikutnya:
require ROOT_PATH . '/app/Controllers/HomeController.php'; // Baris 13 yang sekarang sudah diperbaiki
require ROOT_PATH . '/app/Models/Database.php'; 
require ROOT_PATH . '/app/Models/ProductModel.php';
require ROOT_PATH . '/app/Models/TransactionModel.php';
require ROOT_PATH . '/app/Models/StoreModel.php';

require ROOT_PATH . '/app/Controllers/ProductController.php';
require ROOT_PATH . '/app/Controllers/CheckoutController.php';
require ROOT_PATH . '/app/Controllers/TransactionController.php';
require ROOT_PATH . '/app/Controllers/CartController.php';
require ROOT_PATH . '/app/Controllers/StoreController.php';

// --- 2. Inisialisasi Koneksi DB & Models ---
// ... (lanjutan kode inisialisasi dan routing switch-case)
// --- 2. Inisialisasi Koneksi DB & Models ---
$db = Database::getInstance()->getConnection(); 
$productModel = new ProductModel($db);
$transactionModel = new TransactionModel($db);
$storeModel = new StoreModel($db);
$cartController = new CartController($productModel);

// --- 3. Routing Logic ---
// Membaca URL yang diminta oleh pengguna
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $uri);
// Kami asumsikan segment[0] diabaikan karena kita akan memanggilnya secara spesifik
// Kita ambil segmen yang diperlukan setelah /app.php/

// Untuk kesederhanaan, kita akan memproses URL yang datang setelah /app.php/
$request_path = str_replace('app.php/', '', $uri);
$segments = explode('/', trim($request_path, '/'));

$controller_key = $segments[0] ?: 'home';
$action_key = $segments[1] ?? 'index';

switch ($controller_key) {
    case '': 
    case 'home':
        $controller = new HomeController($productModel); 
        $controller->index();
        break;
        
    case 'product': // Customer: Halaman Detail Produk
        $controller = new ProductController($productModel); 
        $controller->show($segments[1] ?? null);
        break;
        
    case 'checkout': // Customer: Proses Checkout
        $controller = new CheckoutController($transactionModel);
        if ($action_key === 'process') {
            $controller->process();
        } else {
            $controller->index();
        }
        break;
        
    case 'history': // Customer: Riwayat Transaksi
        $controller = new TransactionController($transactionModel); 
        $controller->history();
        break;
    
    case 'cart': // Rute: /app.php/cart, /app.php/cart/add, /app.php/cart/remove/{id}
        $controller = new CartController($productModel);
        
        if ($action_key === 'add') {
            $controller->add(); // POST dari form Product Page
        } elseif ($action_key === 'remove' && isset($segments[2])) {
            $controller->remove($segments[2]); // segments[2] adalah product_id
        } else {
            $controller->index(); // Tampilan keranjang
        }
        break;

    case 'store': // Store/Admin Side
        $controller = new StoreController($storeModel, $productModel);
        
        // ... (Sub-routing Store)
        if ($action_key === 'orders') {
             $controller->orders(); 
        } else {
             $controller->index();
        }
        break;

    default:
        // Halaman 404
        http_response_code(404); 
        echo "404 Halaman tidak ditemukan: {$uri}";
        break;
}