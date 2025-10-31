<?php
require_once __DIR__ . '/../config/config.php';

$message = '';
$showForm = false;

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Cek token valid dan belum kadaluarsa
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
            $new_password = trim($_POST['new_password']);
            $confirm_password = trim($_POST['confirm_password']);

            if ($new_password !== $confirm_password) {
                $message = "<p class='message error'>❌ Password baru dan konfirmasi tidak cocok!</p>";
            } elseif (strlen($new_password) < 6) {
                $message = "<p class='message info'>⚠️ Password minimal 6 karakter!</p>";
            } else {
                // Update password
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $stmtUpdate = $pdo->prepare("UPDATE users SET password=? WHERE id=?");
                $stmtUpdate->execute([$hashed, $user_id]);

                // Hapus token
                $pdo->prepare("DELETE FROM password_resets WHERE user_id=?")->execute([$user_id]);

                $message = "<p class='message success'>✅ Password berhasil diperbarui! <a href='../public/login.php'>Login sekarang</a></p>";
                $showForm = false;
            }
        }
    } else {
        $message = "<p class='message error'>❌ Token tidak valid atau sudah kadaluarsa!</p>";
    }
} else {
    $message = "<p class='message error'>❌ Token tidak ditemukan!</p>";
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
    <h2>🔒 Reset Password</h2>
    <?= $message ?>
    <?php if($showForm): ?>
    <form method="POST">
        <input type="password" name="new_password" placeholder="Password baru" required>
        <input type="password" name="confirm_password" placeholder="Konfirmasi password" required>
        <button type="submit">Perbarui Password</button>
    </form>
    <?php endif; ?>
    <div class="bottom-text">
        <p><a href="../public/login.php">← Kembali ke Login</a></p>
    </div>
</div>
</body>
</html>
