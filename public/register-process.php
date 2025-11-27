<?php
// public/register-process.php
session_start();
require_once "../includes/db.php"; // pastikan $conn adalah mysqli connection

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
$stmt = $conn->prepare("SELECT id FROM auth_users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    $_SESSION['reg_err'] = "Email sudah terdaftar. Silakan login.";
    header("Location: login.php");
    exit;
}
$stmt->close();

// Hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insert ke auth_users (credential)
$stmt = $conn->prepare("INSERT INTO auth_users (username, email, password_hash) VALUES (?, ?, ?)");
$username = null; // kalau kamu ingin pakai username, ambil dari form; sekarang pake email saja
$stmt->bind_param("sss", $username, $email, $hash);

if (!$stmt->execute()) {
    $_SESSION['reg_err'] = "Terjadi kesalahan saat menyimpan pengguna (auth).";
    header("Location: register.php");
    exit;
}

$user_id = $stmt->insert_id;
$stmt->close();

// Insert ke user_profiles
$stmt = $conn->prepare("INSERT INTO user_profiles (user_id, full_name, phone, birth_date) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $user_id, $full_name, $phone, $birth_date);

if ($stmt->execute()) {
    $_SESSION['reg_succ'] = "Pendaftaran berhasil! Silakan login.";
    header("Location: login.php");
    exit;
} else {
    // rollback sederhana: hapus auth_users jika profile gagal
    $stmt->close();
    $conn->query("DELETE FROM auth_users WHERE id = " . intval($user_id));
    $_SESSION['reg_err'] = "Terjadi kesalahan saat menyimpan profil.";
    header("Location: register.php");
    exit;
}