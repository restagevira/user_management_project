<?php
require_once __DIR__ . '/../config/config.php';

$message = '';
$showForm = false;

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // cek token valid dan belum kadaluarsa
    $stmt = $pdo->prepare("
        SELECT pr.user_id, u.nama 
        FROM password_resets pr 
        JOIN users u ON pr.user_id = u.id 
        WHERE pr.token = ? AND pr.expires_at >= NOW()
    ");
    $stmt->execute([$token]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $showForm = true;
        $user_id = $data['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password !== $confirm_password) {
                $message = "⚠️ Password baru dan konfirmasi tidak cocok!";
            } else {
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $update = $pdo->prepare("UPDATE users SET password=? WHERE id=?");
                $update->execute([$hashed, $user_id]);

                // hapus token setelah digunakan
                $pdo->prepare("DELETE FROM password_resets WHERE user_id=?")->execute([$user_id]);

                $message = "✅ Password berhasil diperbarui! <a href='../public/login.php'>Login sekarang</a>";
                $showForm = false;
            }
        }
    } else {
        $message = "⚠️ Token tidak valid atau sudah kadaluarsa!";
    }
} else {
    $message = "⚠️ Token tidak ditemukan!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background: linear-gradient(135deg, #7b4397, #dc2430); display:flex; justify-content:center; align-items:center; height:100vh;">
<div class="form-container">
    <h2>Reset Password</h2>
    <?php if($message) echo "<p class='message'>{$message}</p>"; ?>
    <?php if($showForm): ?>
    <form method="POST">
        <input type="password" name="new_password" placeholder="Password Baru" required>
        <input type="password" name="confirm_password" placeholder="Konfirmasi Password Baru" required>
        <button type="submit">Reset Password</button>
    </form>
    <?php endif; ?>
    <p class="bottom-text"><a href="login.php">← Kembali ke Login</a></p>
</div>
</body>
</html>
