<?php
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}

// Ambil total produk dan pengguna
$totalProduk = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalUser = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin Gudang</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <header>
    <h1>Dashboard Admin Gudang</h1>
    <p>Selamat datang, <?= htmlspecialchars($_SESSION['user_name']); ?> 👋</p>
  </header>

  <nav>
    <a href="../produk/list.php" class="<?= $current_page == 'list.php' ? 'active' : '' ?>">📦 Kelola Produk</a>
    <a href="profile.php" class="<?= $current_page == 'profile.php' ? 'active' : '' ?>">👤 Profil</a>
    <a href="change_password.php" class="<?= $current_page == 'change_password.php' ? 'active' : '' ?>">🔑 Ubah Password</a>
    <a href="../auth/logout.php" class="logout">🚪 Logout</a>
  </nav>

  <div class="container">
    <div class="card">
      <h2>Ringkasan Sistem</h2>
      <p>Di sini kamu bisa mengelola produk, melihat stok, dan memperbarui profil pengguna.</p>
    </div>

    <div class="card">
      <h3>📦 Total Produk: <em><?= $totalProduk ?></em></h3>
      <p>Segera tambahkan data produk kamu melalui menu "Kelola Produk".</p>
    </div>

    <div class="card">
      <h3>👥 Total Pengguna: <em><?= $totalUser ?></em></h3>
      <p>Data pengguna dapat dikelola pada menu profil.</p>
    </div>
  </div>
</body>
</html>
