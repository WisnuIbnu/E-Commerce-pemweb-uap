<?php
// File: app/Controllers/StoreController.php

namespace App\Http\Controllers;

class StoreController
{
    private $storeModel;
    private $productModel;

    public function __construct($storeModel, $productModel)
    {
        $this->storeModel = $storeModel;
        $this->productModel = $productModel;
    }

    private function getCurrentStoreId()
    {
        // HARDCODE: Ganti dengan ID Toko dari Session
        return 1;
    }

    // Dashboard Toko
    public function index()
    {
        $store_id = $this->getCurrentStoreId();
        // Logika autentikasi: cek apakah user adalah seller/admin

        // Ambil data statistik dari StoreModel
        $orders = $this->storeModel->getStoreOrders($store_id); // Contoh data

        require '../app/Views/store/dashboard.php';
    }

    // Tampilkan daftar Pesanan Masuk
    public function orders()
    {
        $store_id = $this->getCurrentStoreId();
        $orders = $this->storeModel->getStoreOrders($store_id);

        require '../app/Views/store/order_list.php';
    }

    // Aksi: Ubah Status Pesanan
    public function updateOrder($transaction_id)
    {
        // ... (Logika update status dan tracking number)
    }

    // ... (Fungsi products() dan createProductForm() berada di sini)
}