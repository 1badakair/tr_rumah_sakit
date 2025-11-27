<?php
// public/change-password-process.php
require_once "../includes/auth.php";   // harus memanggil session_start() dan memastikan user login
require_once "../includes/db.php";

$user_id         = $_SESSION['user_id'] ?? null;
$old_password    = $_POST['old_password'] ?? '';
$new_password    = $_POST['new_password'] ?? '';
$confirm_password= $_POST['confirm_password'] ?? '';

if (!$user_id) {
    // user tidak login
    header("Location: login.php");
    exit;
}

// Validasi awal
if ($old_password === '' || $new_password === '' || $confirm_password === '') {
    $_SESSION['pwd_err'] = "Semua field wajib diisi.";
    header("Location: change-password.php");
    exit;
}

if ($new_password !== $confirm_password) {
    $_SESSION['pwd_err'] = "Konfirmasi password baru tidak sama.";
    header("Location: change-password.php");
    exit;
}

if (strlen($new_password) < 8) {
    $_SESSION['pwd_err'] = "Password baru minimal 8 karakter.";
    header("Location: change-password.php");
    exit;
}

// Ambil password lama dari auth_users
$stmt = $conn->prepare("SELECT password_hash FROM auth_users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($password_hash_db);
$stmt->fetch();
$stmt->close();

if (!$password_hash_db) {
    $_SESSION['pwd_err'] = "User tidak ditemukan.";
    header("Location: change-password.php");
    exit;
}

// Cek password lama benar atau tidak
if (!password_verify($old_password, $password_hash_db)) {
    $_SESSION['pwd_err'] = "Password lama salah.";
    header("Location: change-password.php");
    exit;
}

// Hash password baru
$new_hash = password_hash($new_password, PASSWORD_DEFAULT);

// Update password di database
$stmt = $conn->prepare("UPDATE auth_users SET password_hash = ? WHERE id = ?");
$stmt->bind_param("si", $new_hash, $user_id);

if ($stmt->execute()) {
    $_SESSION['pwd_succ'] = "Password berhasil diubah.";
} else {
    $_SESSION['pwd_err'] = "Terjadi kesalahan saat mengubah password.";
}
$stmt->close();

header("Location: change-password.php");
exit;
