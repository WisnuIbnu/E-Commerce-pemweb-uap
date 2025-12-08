<?php
// File: app/Controllers/ProductController.php

namespace App\Http\Controllers;

class ProductController
{
    private $productModel;

    public function __construct($productModel)
    {
        $this->productModel = $productModel;
    }

    // Product Page (Halaman Produk)
    public function show($product_id)
    {
        $product = $this->productModel->getProductDetails($product_id);

        if (!$product) {
            http_response_code(404);
            echo "Produk tidak ditemukan.";
            return;
        }
        require '../app/Views/product_detail.php';
    }
}