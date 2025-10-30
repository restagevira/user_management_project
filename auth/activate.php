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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Aktivasi Akun</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #e3f2fd);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 450px;
            margin: 100px auto;
            background: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        p {
            color: #555;
            font-size: 16px;
        }
        .success { color: #2e7d32; }
        .error { color: #d32f2f; }
        .info { color: #1976d2; }
        a.button {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background: #1976d2;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }
        a.button:hover {
            background: #1565c0;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($status === 'success'): ?>
            <h2 class="success">🎉 Aktivasi Berhasil</h2>
            <p><?= htmlspecialchars($message) ?></p>
            <a href="../public/login.php" class="button">Login Sekarang</a>
        <?php elseif ($status === 'info'): ?>
            <h2 class="info">ℹ️ Sudah Aktif</h2>
            <p><?= htmlspecialchars($message) ?></p>
            <a href="../public/login.php" class="button">Ke Halaman Login</a>
        <?php else: ?>
            <h2 class="error">❌ Aktivasi Gagal</h2>
            <p><?= htmlspecialchars($message) ?></p>
            <a href="../public/register.php" class="button">Daftar Ulang</a>
        <?php endif; ?>
    </div>
</body>
</html>
