<?php
require_once __DIR__ . '/../config/config.php';

$status = '';
$message = '';

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE verification_code = ?");
    $stmt->execute([$code]);
    $user = $stmt->fetch();

    if ($user) {
        if ($user['is_verified'] == 1) {
            $status = 'info';
            $message = 'Akun kamu sudah aktif sebelumnya.';
        } else {
            $update = $pdo->prepare("UPDATE users SET is_verified = 1, verification_code = NULL WHERE verification_code = ?");
            $update->execute([$code]);
            $status = 'success';
            $message = 'Akun kamu berhasil diaktifkan! Sekarang kamu bisa login.';
        }
    } else {
        $status = 'error';
        $message = 'Kode aktivasi tidak valid atau akun sudah diaktifkan.';
    }
} else {
    $status = 'error';
    $message = 'Kode aktivasi tidak ditemukan.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Aktivasi Akun</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <?php if ($status === 'success'): ?>
            <h2 class="success">🎉 Aktivasi Berhasil</h2>
            <p><?= htmlspecialchars($message) ?></p>
            <a href="../public/login.php" class="bottom-text">Login Sekarang</a>
        <?php elseif ($status === 'info'): ?>
            <h2 class="info">ℹ️ Sudah Aktif</h2>
            <p><?= htmlspecialchars($message) ?></p>
            <a href="../public/login.php" class="bottom-text">Ke Halaman Login</a>
        <?php else: ?>
            <h2 class="error">❌ Aktivasi Gagal</h2>
            <p><?= htmlspecialchars($message) ?></p>
            <a href="../public/register.php" class="bottom-text">Daftar Ulang</a>
        <?php endif; ?>
    </div>
</body>
</html>
