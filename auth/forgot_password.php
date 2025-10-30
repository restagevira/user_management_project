<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/mail_config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Cek email ada di database
    $stmt = $pdo->prepare("SELECT id, nama FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Hapus token lama jika ada
        $pdo->prepare("DELETE FROM password_resets WHERE user_id = ?")->execute([$user['id']]);

        // Buat token unik untuk reset password
        $token = bin2hex(random_bytes(50));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); // berlaku 1 jam

        // Simpan token ke database
        $stmtToken = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmtToken->execute([$user['id'], $token, $expires]);

        // Buat link reset password
        $resetLink = BASE_URL . "/auth/reset_password.php?token=" . urlencode($token);

        // Kirim email
        if (sendResetPasswordEmail($email, $user['nama'], $resetLink)) {
            $message = "✅ Tautan reset password telah dikirim ke email Anda!";
        } else {
            $message = "⚠️ Gagal mengirim email. Coba lagi.";
        }
    } else {
        $message = "❌ Email tidak terdaftar!";
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
<body>
<div class="form-container">
    <h2>Lupa Password</h2>
    <?php if($message) echo "<p class='message'>{$message}</p>"; ?>
    <form method="POST">
        <label>Email Terdaftar:</label>
        <input type="email" name="email" required>
        <button type="submit">Kirim Tautan Reset</button>
    </form>
    <p class="bottom-text"><a href="../public/login.php">← Kembali ke Login</a></p>
</div>
</body>
</html>
