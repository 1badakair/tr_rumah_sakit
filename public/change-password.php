<?php
require_once "../includes/auth.php"; // sudah start session
$err  = $_SESSION['pwd_err'] ?? "";
$succ = $_SESSION['pwd_succ'] ?? "";
unset($_SESSION['pwd_err'], $_SESSION['pwd_succ']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ganti Password</title>
</head>
<body>

<h2>Ganti Password</h2>

<?php if ($succ): ?>
    <p style="color:green;"><?= htmlspecialchars($succ) ?></p>
<?php endif; ?>

<?php if ($err): ?>
    <p style="color:red;"><?= htmlspecialchars($err) ?></p>
<?php endif; ?>

<form action="change-password-process.php" method="POST">
    <label>Password lama</label><br>
    <input type="password" name="old_password" required><br><br>

    <label>Password baru</label><br>
    <input type="password" name="new_password" required><br><br>

    <label>Konfirmasi password baru</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Simpan Password</button>
</form>

<p><a href="profile.php">Kembali ke profil</a></p>

</body>
</html>
