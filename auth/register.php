<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/mail_config.php';

// Jalankan proses hanya jika request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validasi kolom wajib
    if (!$nama || !$email || !$password) {
        $_SESSION['message'] = "❌ Semua kolom harus diisi!";
        header('Location: ../public/register.php');
        exit;
    }

    // Cek apakah email sudah terdaftar
    $cek = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $cek->execute([$email]);
    if ($cek->rowCount() > 0) {
        $_SESSION['message'] = "⚠️ Email sudah terdaftar!";
        header('Location: ../public/register.php');
        exit;
    }

    // Hash password dan buat kode verifikasi
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $code = bin2hex(random_bytes(16));

    // Simpan ke database
    $stmt = $pdo->prepare("
        INSERT INTO users (nama, email, password, verification_code, is_verified, created_at)
        VALUES (?, ?, ?, ?, 0, NOW())
    ");
    if ($stmt->execute([$nama, $email, $hashed, $code])) {
        // Kirim email aktivasi
        $activationLink = BASE_URL . "/auth/activate.php?code=$code";
        if (sendActivationEmail($email, $activationLink)) {
            $_SESSION['message'] = "✅ Registrasi berhasil! Silakan cek email untuk aktivasi akun.";
        } else {
            $_SESSION['message'] = "⚠️ Registrasi berhasil, namun email aktivasi gagal dikirim.";
        }
    } else {
        $_SESSION['message'] = "❌ Terjadi kesalahan saat menyimpan data.";
    }

    header('Location: ../public/register.php');
    exit;
}
?>
