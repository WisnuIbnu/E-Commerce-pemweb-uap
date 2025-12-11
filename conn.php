<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "UAPPEMWEB12"; // <<< GANTI NAMA DB

$mysqli = new mysqli($host, $user, $pass, $db_name);

if ($mysqli->connect_errno) {
    die("Koneksi database gagal: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8");
?>
