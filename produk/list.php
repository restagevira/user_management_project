<?php
require_once '../config/config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}

// Ambil semua produk
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hitung total produk untuk dashboard
$totalProduk = count($products);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Produk</title>
  <style>
    body { font-family: 'Segoe UI'; background: #f4f4f4; margin: 0; padding: 0; }
    .container { width: 80%; margin: 40px auto; background: white; border-radius: 10px; padding: 20px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
    th { background: #7b4397; color: white; }
    a.btn { padding: 8px 12px; background: #7b4397; color: white; border-radius: 5px; text-decoration: none; }
    a.btn:hover { background: #5c2a6a; }
    .actions a { margin: 0 5px; }
    .total { margin-bottom: 15px; font-weight: bold; }
  </style>
</head>
<body>
  <div class="container">
    <h2>📦 Daftar Produk</h2>
    <p class="total">Total Produk: <?= $totalProduk ?></p>
    <p>
      <a href="add.php" class="btn">+ Tambah Produk</a> | 
      <a href="../dashboard/admin.php" class="btn">🏠 Kembali ke Dashboard</a>
    </p>
    <table>
      <tr>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>Kategori</th>
        <th>Stok</th>
        <th>Harga</th>
        <th>Aksi</th>
      </tr>
      <?php if(count($products) > 0): ?>
        <?php foreach ($products as $p): ?>
        <tr>
          <td><?= $p['id'] ?></td>
          <td><?= htmlspecialchars($p['nama_produk']) ?></td>
          <td><?= htmlspecialchars($p['kategori']) ?></td>
          <td><?= $p['stok'] ?></td>
          <td>Rp <?= number_format($p['harga'], 2, ',', '.') ?></td>
          <td class="actions">
            <a href="edit.php?id=<?= $p['id'] ?>">✏️ Edit</a>
            <a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')">🗑️ Hapus</a>
          </td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="6">Belum ada produk yang ditambahkan.</td>
        </tr>
      <?php endif; ?>
    </table>
  </div>
</body>
</html>
