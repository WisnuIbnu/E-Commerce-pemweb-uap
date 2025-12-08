<?php
// File: app/Models/Database.php

namespace App\Models;

use PDO;

class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        // --- Membaca Konfigurasi dari File Laravel ---
        $db_config_file = __DIR__ . '/../../config/database.php';
        if (!file_exists($db_config_file)) {
            die("Error: File config/database.php tidak ditemukan.");
        }

        $db_config = require $db_config_file;
        $config = $db_config['connections']['mysql'] ?? null;
        if (!$config) {
            die("Error: Konfigurasi koneksi 'mysql' tidak ditemukan.");
        }

        // --- Kredensial (HARUS DISESUAIKAN MANUAL OLEH USER) ---
        $db_name = 'walkuno_db'; // GANTI
        $user = 'root'; // GANTI
        $pass = ''; // GANTI
        $host = $config['host'];
        $charset = $config['charset'];
        $port = $config['port'];

        $dsn = "mysql:host={$host};port={$port};dbname={$db_name};charset={$charset}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->conn = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            die("Koneksi Database Gagal: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}