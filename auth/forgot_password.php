<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/mail_config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Cek email di database
    $stmt = $pdo->prepare("SELECT id, nama FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Hapus token lama
        $pdo->prepare("DELETE FROM password_resets WHERE user_id = ?")->execute([$user['id']]);

        // Buat token baru
        $token = bin2hex(random_bytes(50));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); // berlaku 1 jam

        // Simpan token
        $stmtToken = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmtToken->execute([$user['id'], $token, $expires]);

        // Buat link reset
        $resetLink = BASE_URL . "/auth/reset_password.php?token=" . urlencode($token);

        // Kirim email
        if (sendResetPasswordEmail($email, $user['nama'], $resetLink)) {
            $message = "<p class='message success'>✅ Tautan reset password telah dikirim ke email Anda!</p>";
        } else {
            $message = "<p class='message error'>⚠️ Gagal mengirim email. Coba lagi.</p>";
        }
    } else {
        $message = "<p class='message error'>❌ Email tidak terdaftar!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background: linear-gradient(135deg, #7b4397, #dc2430); display:flex; justify-content:center; align-items:center; height:100vh;">
<div class="form-container">
    <h2>🔑 Lupa Password</h2>
    <?= $message ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Masukkan email terdaftar" required>
        <button type="submit">Kirim Tautan Reset</button>
    </form>
    <div class="bottom-text">
        <p><a href="../public/login.php">← Kembali ke Login</a></p>
    </div>
</div>
</body>
</html>
