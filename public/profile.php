<?php
require_once "../includes/auth.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Pengguna</title>
</head>
<body>

<h2>Halo, <?= htmlspecialchars($_SESSION['user_name']); ?></h2>
<p>Email: <?= htmlspecialchars($_SESSION['user_email']); ?></p>

<p>
    <a href="change-password.php">Ganti password</a> |
    <a href="logout.php">Logout</a>
</p>

</body>
</html>
