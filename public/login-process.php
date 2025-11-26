<?php
// public/login-process.php
session_start();
require_once "../includes/db.php";

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    $_SESSION['login_err'] = "Email dan password wajib diisi.";
    header("Location: login.php");
    exit;
}

// Cari user login biasa (provider IS NULL)
$stmt = $conn->prepare("
    SELECT id, full_name, email, password_hash
    FROM users
    WHERE email = ? AND provider IS NULL
");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $_SESSION['login_err'] = "Akun tidak ditemukan atau hanya tersedia via Google/Facebook.";
    header("Location: login.php");
    exit;
}

$stmt->bind_result($id, $full_name, $email_db, $password_hash);
$stmt->fetch();

if (password_verify($password, $password_hash)) {
    $_SESSION['user_id']    = $id;
    $_SESSION['user_name']  = $full_name;
    $_SESSION['user_email'] = $email_db;

    header("Location: profile.php");
    exit;
} else {
    $_SESSION['login_err'] = "Password salah.";
    header("Location: login.php");
    exit;
}
