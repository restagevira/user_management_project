<?php
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user = $pdo->prepare("SELECT nama, email FROM users WHERE id = ?");
$user->execute([$user_id]);
$user = $user->fetch();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    $update = $pdo->prepare("UPDATE users SET nama = ?, email = ? WHERE id = ?");
    if($update->execute([$nama, $email, $user_id])) {
        $message = "Profil berhasil diperbarui!";
        $user['nama'] = $nama;
        $user['email'] = $email;
        $_SESSION['user_name'] = $nama;
    } else {
        $message = "Terjadi kesalahan saat memperbarui profil.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header>
  <h1>Profil Pengguna</h1>
  <p><a href="admin.php">← Kembali ke Dashboard</a></p>
</header>

<div class="container">
  <div class="card form-profile">
    <?php if($message) echo "<p class='message'>$message</p>"; ?>
    <form method="POST">
        <label>Nama:</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']); ?>" required>
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        <button type="submit">Simpan Perubahan</button>
    </form>
  </div>
</div>
</body>
</html>
