<?php
require_once '../config/config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user['is_verified'] == 0) {
            $message = "⚠️ Akun belum aktif. Silakan cek email untuk aktivasi.";
        } elseif(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama'];
            $_SESSION['user_email'] = $user['email'];
            header('Location: ../dashboard/admin.php');
            exit;
        } else {
            $message = "⚠️ Password salah!";
        }
    } else {
        $message = "⚠️ Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin Gudang</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background: linear-gradient(135deg, #7b4397, #dc2430); display:flex; justify-content:center; align-items:center; height:100vh;">
<div class="form-container">
    <h2>Login Admin Gudang</h2>
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Masukkan email" required>
        <input type="password" name="password" placeholder="Masukkan password" required>
        <button type="submit">Masuk</button>
    </form>
    <div class="bottom-text">
        <p><a href="register.php">Belum punya akun? Daftar di sini</a></p>
        <p><a href="forgot_password.php">Lupa password?</a></p>
    </div>
</div>
</body>
</html>
