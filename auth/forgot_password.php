<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/mail_config.php'; // PHPMailer config

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // cek email ada di database
    $stmt = $pdo->prepare("SELECT id, nama FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // buat token unik untuk reset password
        $token = bin2hex(random_bytes(50));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // simpan token dan waktu kedaluwarsa di database
        $stmtToken = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmtToken->execute([$user['id'], $token, $expires]);

        // kirim email
        $resetLink = BASE_URL . "/auth/reset_password.php?token=$token";
        if(sendResetPasswordEmail($email, $user['nama'], $resetLink)){
            $message = "✅ Tautan reset password telah dikirim ke email Anda!";
        } else {
            $message = "⚠️ Gagal mengirim email. Silakan coba lagi.";
        }
    } else {
        $message = "⚠️ Email tidak terdaftar!";
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
    <h2>Lupa Password</h2>
    <?php if($message) echo "<p class='message'>{$message}</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Masukkan email terdaftar" required>
        <button type="submit">Kirim Tautan Reset</button>
    </form>
    <p class="bottom-text"><a href="login.php">← Kembali ke Login</a></p>
</div>
</body>
</html>
