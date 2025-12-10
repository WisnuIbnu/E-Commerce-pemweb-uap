<?php
// File: app/Controllers/TransactionController.php

namespace App\Http\Controllers;

class TransactionController
{
    private $transactionModel;

    public function __construct($transactionModel)
    {
        $this->transactionModel = $transactionModel;
    }

    private function getCurrentBuyerId()
    {
        // HARDCODE: Ganti dengan Buyer ID dari Session/Auth
        return 1;
    }

    // Transaction History Page
    public function history()
    {
        $buyer_id = $this->getCurrentBuyerId();
        $transactions = $this->transactionModel->getUserTransactions($buyer_id);

        require '../app/Views/transaction_history.php';
    }

    // ... (metode untuk submitReview jika diperlukan)
}