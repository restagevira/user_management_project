<?php
date_default_timezone_set('Asia/Jakarta');
session_start();

define('BASE_URL', 'http://localhost/user_management');

$host = 'localhost';
$db   = 'user_management_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die('Koneksi gagal: '.$e->getMessage());
}
