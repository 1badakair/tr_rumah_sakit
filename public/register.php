<?php
session_start();
$err  = $_SESSION['reg_err'] ?? "";
$succ = $_SESSION['reg_succ'] ?? "";
unset($_SESSION['reg_err'], $_SESSION['reg_succ']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun</title>
</head>
<body>

<h2>Daftar Akun</h2>

<?php if ($succ): ?>
    <p style="color:green;"><?= htmlspecialchars($succ) ?></p>
<?php endif; ?>

<?php if ($err): ?>
    <p style="color:red;"><?= htmlspecialchars($err) ?></p>
<?php endif; ?>

<form action="register-process.php" method="POST">

    <label>Nama Lengkap</label><br>
    <input type="text" name="full_name" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Nomor Telepon</label><br>
    <input type="text" name="phone" required><br><br>

    <label>Tanggal Lahir</label><br>
    <input type="date" name="birth_date" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <label>Konfirmasi Password</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Daftar Sekarang</button>
</form>

<p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>

</body>
</html>
