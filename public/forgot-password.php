<?php
session_start();
$err  = $_SESSION['fp_err']  ?? "";
$succ = $_SESSION['fp_succ'] ?? "";
unset($_SESSION['fp_err'], $_SESSION['fp_succ']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
</head>
<body>

<h2>Reset Password</h2>

<?php if ($succ): ?>
    <p style="color:green;"><?= htmlspecialchars($succ) ?></p>
<?php endif; ?>

<?php if ($err): ?>
    <p style="color:red;"><?= htmlspecialchars($err) ?></p>
<?php endif; ?>

<form action="forgot-password-process.php" method="POST">
    <label>Email yang terdaftar</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password baru</label><br>
    <input type="password" name="new_password" required><br><br>

    <label>Konfirmasi password baru</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Reset Password</button>
</form>

<p><a href="login.php">Kembali ke login</a></p>

</body>
</html>
