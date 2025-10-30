<?php
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!password_verify($old_password, $user['password'])) {
        $message = "Password lama salah!";
    } elseif ($new_password !== $confirm_password) {
        $message = "Password baru dan konfirmasi tidak cocok!";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        if($pdo->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$hashed, $user_id])) {
            $message = "Password berhasil diubah!";
        } else {
            $message = "Terjadi kesalahan saat mengganti password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ubah Password</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header>
  <h1>Ubah Password</h1>
  <p><a href="admin.php">← Kembali ke Dashboard</a></p>
</header>

<div class="container">
  <div class="card form-password">
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <form method="POST">
        <label>Password Lama:</label>
        <input type="password" name="old_password" required>
        <label>Password Baru:</label>
        <input type="password" name="new_password" required>
        <label>Konfirmasi Password Baru:</label>
        <input type="password" name="confirm_password" required>
        <button type="submit">Ganti Password</button>
    </form>
  </div>
</div>
</body>
</html>
