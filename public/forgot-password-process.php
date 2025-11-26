<?php
session_start();
require_once "../includes/db.php";

$email      = trim($_POST['email'] ?? '');
$new_pass   = $_POST['new_password'] ?? '';
$confirm    = $_POST['confirm_password'] ?? '';

if ($email === '' || $new_pass === '' || $confirm === '') {
    $_SESSION['fp_err'] = "Semua field wajib diisi.";
    header("Location: forgot-password.php");
    exit;
}

if ($new_pass !== $confirm) {
    $_SESSION['fp_err'] = "Konfirmasi password tidak sama.";
    header("Location: forgot-password.php");
    exit;
}

if (strlen($new_pass) < 8) {
    $_SESSION['fp_err'] = "Password baru minimal 8 karakter.";
    header("Location: forgot-password.php");
    exit;
}

// cek apakah email ada
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $_SESSION['fp_err'] = "Email tidak terdaftar.";
    header("Location: forgot-password.php");
    exit;
}
$stmt->close();

// update password
$new_hash = password_hash($new_pass, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
$stmt->bind_param("ss", $new_hash, $email);

if ($stmt->execute()) {
    $_SESSION['fp_succ'] = "Password berhasil direset. Silakan login.";
    header("Location: login.php");
    exit;
} else {
    $_SESSION['fp_err'] = "Terjadi kesalahan saat mengupdate password.";
    header("Location: forgot-password.php");
    exit;
}