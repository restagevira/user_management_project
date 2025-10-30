<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        if ($user['is_verified'] == 0) {
            $_SESSION['message'] = "Akun belum aktif. Silakan cek email untuk aktivasi.";
            header('Location: ../public/login.php');
            exit;
        }

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama'];
            $_SESSION['user_email'] = $user['email'];
            header('Location: ../dashboard/admin.php');
            exit;
        } else {
            $_SESSION['message'] = "Password salah!";
            header('Location: ../public/login.php');
            exit;
        }
    } else {
        $_SESSION['message'] = "Email tidak ditemukan!";
        header('Location: ../public/login.php');
        exit;
    }
}
