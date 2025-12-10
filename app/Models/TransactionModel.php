<?php
// File: app/Models/TransactionModel.php

namespace App\Models;

use PDO;

class TransactionModel
{
    private $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getBuyerInfo($user_id)
    {
        $sql = "SELECT u.name, b.phone_number, s.address, s.city, s.postal_code 
                FROM user u 
                JOIN buyer b ON u.id = b.user_id 
                -- Asumsi data alamat diambil dari tabel store (untuk contoh default)
                JOIN store s ON s.user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }

    public function createTransaction($buyer_id, $cart_items, $form_data, $store_id)
    {
        // ... (Kode lengkap dari Langkah 10 untuk database transaction)
        $this->db->beginTransaction();
        try {
            // 1. INSERT ke tabel 'transaction' (mengurangi kompleksitas untuk contoh)
            $transaction_code = 'TRX-' . time();
            $total_items_price = array_sum(array_column($cart_items, 'subtotal'));
            $grand_total = $total_items_price + $form_data['shipping_cost'];

            $sql_transaction = "INSERT INTO `transaction` 
                (code, buyer_id, store_id, address, city, postal_code, shipping_type, shipping_cost, grand_total, payment_status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
            $stmt_t = $this->db->prepare($sql_transaction);
            $stmt_t->execute([
                $transaction_code,
                $buyer_id,
                $store_id,
                $form_data['address'],
                $form_data['city'],
                $form_data['postal_code'],
                $form_data['shipping_type'],
                $form_data['shipping_cost'],
                $grand_total
            ]);

            $transaction_id = $this->db->lastInsertId();

            // 2. INSERT ke 'transactiondetail' & UPDATE Stok
            foreach ($cart_items as $item) {
                // Insert detail item
                $sql_detail = "INSERT INTO `transactiondetail` 
                    (transaction_id, product_id, qty, subtotal) VALUES (?, ?, ?, ?)";
                $this->db->prepare($sql_detail)->execute([$transaction_id, $item['id'], $item['qty'], $item['subtotal']]);

                // UPDATE Stok Produk
                $sql_stock = "UPDATE `product` SET stock = stock - ? WHERE id = ?";
                $this->db->prepare($sql_stock)->execute([$item['qty'], $item['id']]);
            }

            $this->db->commit();
            return $transaction_id;

        } catch (\Exception $e) {
            $this->db->rollBack();
            throw new \Exception("Gagal menyimpan pesanan: " . $e->getMessage());
        }
    }

    public function getUserTransactions($buyer_id)
    {
        $sql = "SELECT t.*, SUM(td.qty) as total_items 
                FROM `transaction` t 
                JOIN `transactiondetail` td ON t.id = td.transaction_id 
                WHERE t.buyer_id = ? 
                GROUP BY t.id ORDER BY t.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$buyer_id]);
        return $stmt->fetchAll();
    }
}