<?php
// File: app/Models/StoreModel.php

namespace App\Models;

use PDO;

class StoreModel
{
    private $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getStoreOrders($store_id)
    {
        // Mengambil pesanan untuk Store Side
        $sql = "SELECT t.*, u.name as buyer_name 
                FROM `transaction` t 
                JOIN buyer b ON t.buyer_id = b.id
                JOIN user u ON b.user_id = u.id
                WHERE t.store_id = ? 
                ORDER BY t.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$store_id]);
        return $stmt->fetchAll();
    }

    public function updateOrderStatus($transaction_id, $new_status, $tracking_number = null)
    {
        // Memperbarui status pesanan
        $sql = "UPDATE `transaction` SET payment_status = ?, tracking_number = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$new_status, $tracking_number, $transaction_id]);
    }

    // ... Tambahkan fungsi CRUD produk toko di sini
}