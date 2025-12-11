<?php
// File: app/Models/ProductModel.php

namespace App\Models;

use PDO;

class ProductModel
{
    private $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllProducts($filters = [])
    {
        $sql = "SELECT p.*, pc.name AS category_name 
                FROM product p 
                JOIN productcategory pc ON p.product_category_id = pc.id 
                WHERE p.stock > 0";
        // Tambahkan filter jika ada (misal: kategori, harga)
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductDetails($product_id)
    {
        $sql = "SELECT p.*, pc.name AS category_name, pc.description AS category_desc
                FROM product p
                JOIN productcategory pc ON p.product_category_id = pc.id
                WHERE p.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();

        if ($product) {
            // Ambil Review pembeli
            $sql_reviews = "SELECT pr.rating, pr.review, u.name as user_name 
                            FROM productreview pr 
                            JOIN transaction t ON pr.transaction_id = t.id 
                            JOIN buyer b ON t.buyer_id = b.id 
                            JOIN user u ON b.user_id = u.id 
                            WHERE pr.product_id = ?";
            $stmt_reviews = $this->db->prepare($sql_reviews);
            $stmt_reviews->execute([$product_id]);
            $product['reviews'] = $stmt_reviews->fetchAll();

            // Ambil Foto Produk
            $sql_images = "SELECT image FROM productimage WHERE product_id = ?";
            $stmt_images = $this->db->prepare($sql_images);
            $stmt_images->execute([$product_id]);
            $product['images'] = $stmt_images->fetchAll();
        }
        return $product;
    }

    public function getProductForCart($product_id)
    {
        $sql = "SELECT id, name, price, stock FROM product WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetch();
    }
}