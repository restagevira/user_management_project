<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $stmt = $pdo->prepare("INSERT INTO products (nama_produk, kategori, stok, harga) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nama, $kategori, $stok, $harga]);

    header('Location: list.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Produk</title>
  <style>
    body { font-family: 'Segoe UI'; background: #f9f9f9; display: flex; justify-content: center; align-items: center; height: 100vh; }
    form { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.2); width: 400px; }
    input, select { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 6px; }
    button { width: 100%; padding: 12px; background: #7b4397; color: white; border: none; border-radius: 6px; cursor: pointer; }
  </style>
</head>
<body>
  <form method="POST">
    <h2>Tambah Produk</h2>
    <input type="text" name="nama_produk" placeholder="Nama produk" required>
    <input type="text" name="kategori" placeholder="Kategori" required>
    <input type="number" name="stok" placeholder="Jumlah stok" required>
    <input type="number" step="0.01" name="harga" placeholder="Harga" required>
    <button type="submit">Simpan</button>
  </form>
</body>
</html>
