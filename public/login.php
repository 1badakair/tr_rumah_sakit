<?php
session_start();
$err = $_SESSION['login_err'] ?? "";
unset($_SESSION['login_err']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>Login ke Hermina Hospital</h2>

<?php if ($err): ?>
    <p style="color:red;"><?= htmlspecialchars($err) ?></p>
<?php endif; ?>

<form action="login-process.php" method="POST">
    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Masuk</button>
</form>

<p><a href="forgot-password.php">Lupa password?</a></p>
<p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>

<hr>
<p>Atau login dengan:</p>
<button onclick="location.href='google-login.php'">Google</button>

</body>
</html>
