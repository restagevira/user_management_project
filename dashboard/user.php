<?php
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pengguna</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header>
  <h1>Dashboard Pengguna</h1>
</header>

<div class="container">
  <div class="card">
    <h2>Halo <?= htmlspecialchars($_SESSION['user_name']); ?></h2>
    <p>Selamat datang di Dashboard Pengguna.</p>
    <p><a href="../auth/logout.php" class="logout">Logout</a></p>
  </div>
</div>
</body>
</html>
