<?php
require_once '../config/config.php';
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Registrasi Akun</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="form-container">
    <h2>📝 Registrasi Akun</h2>
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <form method="POST" action="../auth/register.php">
      <input type="text" name="nama" placeholder="Nama Lengkap" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Kata Sandi" required>
      <button type="submit">Daftar</button>
    </form>
    <div class="bottom-text">
      Sudah punya akun? <a href="login.php">Login di sini</a>
    </div>
</div>
</body>
</html>
