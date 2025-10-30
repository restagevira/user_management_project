<?php
// -----------------------------
// CONFIGURATION FILE SEDERHANA
// -----------------------------

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL
define('BASE_URL', 'http://localhost/user_management/public');

// Database
$db_host = '127.0.0.1';
$db_name = 'user_management_db';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Gagal terhubung ke database: " . $e->getMessage());
}
?>
