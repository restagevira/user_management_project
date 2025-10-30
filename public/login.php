<?php
require_once '../config/config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ../dashboard/admin.php');
    exit;
}

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin Gudang</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background: linear-gradient(135deg, #7b4397, #dc2430); display:flex; justify-content:center; align-items:center; height:100vh;">
<div class="form-container">
    <h2>Login Admin Gudang</h2>
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <form method="POST" action="../auth/login.php">
      <input type="email" name="email" placeholder="Masukkan email" required>
      <input type="password" name="password" placeholder="Masukkan password" required>
      <button type="submit">Masuk</button>
    </form>
    <div class="bottom-text">
      <p><a href="../public/register.php">Belum punya akun? Daftar di sini</a></p>
      <p><a href="../auth/forgot_password.php">Lupa password?</a></p>
    </div>
</div>
</body>
</html>
