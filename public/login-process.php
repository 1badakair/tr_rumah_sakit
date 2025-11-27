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

// Ambil credential dari auth_users
$stmt = $conn->prepare("
    SELECT id, password_hash
    FROM auth_users
    WHERE email = ? AND provider IS NULL
    LIMIT 1
");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $stmt->close();
    $_SESSION['login_err'] = "Akun tidak ditemukan atau hanya tersedia via Google/Facebook.";
    header("Location: login.php");
    exit;
}

$stmt->bind_result($id, $password_hash);
$stmt->fetch();
$stmt->close();

if (!password_verify($password, $password_hash)) {
    $_SESSION['login_err'] = "Password salah.";
    header("Location: login.php");
    exit;
}

// Ambil profil (full_name)
$stmt = $conn->prepare("SELECT full_name FROM user_profiles WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($full_name);
$stmt->fetch();
$stmt->close();

// Set session
$_SESSION['user_id']    = $id;
$_SESSION['user_name']  = $full_name ?? '';
$_SESSION['user_email'] = $email;

header("Location: profile.php");
exit;
