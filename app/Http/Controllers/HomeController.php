<?php
// File: app/Controllers/HomeController.php

namespace App\Http\Controllers;

class HomeController
{
    private $productModel;

    public function __construct($productModel)
    {
        $this->productModel = $productModel;
    }

    // Homepage
    public function index()
    {
        $categories = ['Sneakers', 'Running Shoes', 'Loafers', 'Boots', 'Sandals'];
        $filters = $_GET;

        $products = $this->productModel->getAllProducts($filters);

        require '../app/Views/homepage.php';
    }
}