<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/mail_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!$nama || !$email || !$password) {
        $_SESSION['message'] = "❌ Semua kolom harus diisi!";
    } else {
        $cek = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $cek->execute([$email]);
        if ($cek->rowCount() > 0) {
            $_SESSION['message'] = "⚠️ Email sudah terdaftar!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $code = bin2hex(random_bytes(16));
            $stmt = $pdo->prepare("INSERT INTO users (nama,email,password,verification_code,is_verified,created_at) VALUES (?,?,?,?,0,NOW())");
            if ($stmt->execute([$nama,$email,$hashed,$code])) {
                if(sendActivationEmail($email, BASE_URL."/auth/activate.php?code=$code")){
                    $_SESSION['message'] = "✅ Registrasi berhasil! Silakan cek email untuk aktivasi akun.";
                } else {
                    $_SESSION['message'] = "⚠️ Registrasi berhasil, tapi gagal mengirim email aktivasi.";
                }
            } else {
                $_SESSION['message'] = "❌ Terjadi kesalahan saat registrasi.";
            }
        }
    }
    header('Location: ../public/register.php');
    exit;
}
