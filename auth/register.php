<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/mail_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($nama) || empty($email) || empty($password)) {
        $message = "❌ Semua kolom harus diisi!";
    } else {
        $cek = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $cek->execute([$email]);
        if ($cek->rowCount() > 0) {
            $message = "⚠️ Email sudah terdaftar!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $verification_code = bin2hex(random_bytes(16));

            $stmt = $pdo->prepare("
                INSERT INTO users (nama, email, password, verification_code, is_verified, created_at)
                VALUES (?, ?, ?, ?, 0, NOW())
            ");
            if ($stmt->execute([$nama, $email, $hashed_password, $verification_code])) {
                $link = BASE_URL . "/auth/activate.php?code=$verification_code";
                if(sendActivationEmail($email, $link)){
                    $message = "✅ Registrasi berhasil! Silakan cek email untuk aktivasi akun.";
                } else {
                    $message = "⚠️ Registrasi berhasil, tapi gagal mengirim email aktivasi.";
                }
            } else {
                $message = "❌ Terjadi kesalahan saat registrasi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Admin Gudang</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="form-container">
    <h2>Daftar Akun Admin Gudang</h2>
    <?php if($message) echo "<p class='message'>{$message}</p>"; ?>
    <form method="POST">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Daftar</button>
    </form>
    <p class="bottom-text"><a href="login.php">← Kembali ke Login</a></p>
</div>
</body>
</html>
