<?php
require_once '../config/config.php';
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Akun</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background: linear-gradient(135deg, #7b4397, #dc2430); display:flex; justify-content:center; align-items:center; height:100vh;">
  <div class="form-container">
    <h2>📝 Registrasi Akun</h2>

    <?php if ($message): ?>
      <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" action="../auth/register.php">
      <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
      <input type="email" name="email" placeholder="Masukkan email aktif" required>
      <input type="password" name="password" placeholder="Masukkan kata sandi" required>
      <button type="submit">Daftar Sekarang</button>
    </form>

    <div class="bottom-text">
      <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
  </div>
</body>
</html>
