<?php
session_start();
require_once "../includes/db.php";

$full_name  = trim($_POST['full_name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$phone      = trim($_POST['phone'] ?? '');
$birth_date = $_POST['birth_date'] ?? '';
$password   = $_POST['password'] ?? '';
$confirm    = $_POST['confirm_password'] ?? '';

// Validasi dasar
if ($full_name === '' || $email === '' || $phone === '' || $birth_date === '' || $password === '' || $confirm === '') {
    $_SESSION['reg_err'] = "Semua field wajib diisi.";
    header("Location: register.php");
    exit;
}

if ($password !== $confirm) {
    $_SESSION['reg_err'] = "Konfirmasi password tidak sama.";
    header("Location: register.php");
    exit;
}

if (strlen($password) < 8) {
    $_SESSION['reg_err'] = "Password minimal 8 karakter.";
    header("Location: register.php");
    exit;
}

// Cek email sudah ada?
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['reg_err'] = "Email sudah terdaftar. Silakan login.";
    header("Location: login.php");
    exit;
}
$stmt->close();

// Hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insert ke database
$stmt = $conn->prepare("
    INSERT INTO users (full_name, email, phone, birth_date, password_hash)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param("sssss", $full_name, $email, $phone, $birth_date, $hash);

if ($stmt->execute()) {
    $_SESSION['reg_succ'] = "Pendaftaran berhasil! Silakan login.";
    header("Location: login.php");
    exit;
} else {
    $_SESSION['reg_err'] = "Terjadi kesalahan. Coba lagi.";
    header("Location: register.php");
    exit;
}
