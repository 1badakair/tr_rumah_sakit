<?php
// public/google-callback.php
session_start();
require_once "../includes/db.php";

$client_id     = "GOOGLE_CLIENT_ID_KAMU";
$client_secret = "GOOGLE_CLIENT_SECRET_KAMU";
$redirect_uri  = "http://localhost/public/google-callback.php";

if (!isset($_GET['code'])) {
    echo "Kode tidak ditemukan.";
    exit;
}

$code = $_GET['code'];

// Tukar code menjadi access_token
$token_url = "https://oauth2.googleapis.com/token";

$data = [
    "code"          => $code,
    "client_id"     => $client_id,
    "client_secret" => $client_secret,
    "redirect_uri"  => $redirect_uri,
    "grant_type"    => "authorization_code"
];

$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$token_info = json_decode($response, true);
$access_token = $token_info["access_token"] ?? null;

if (!$access_token) {
    echo "Gagal mendapatkan access_token.";
    exit;
}

// Ambil data user dari Google
$ch = curl_init("https://www.googleapis.com/oauth2/v2/userinfo");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer {$access_token}"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$user_info = curl_exec($ch);
curl_close($ch);

$user = json_decode($user_info, true);

$google_id = $user['id'] ?? null;
$email     = $user['email'] ?? null;
$name      = $user['name'] ?? $user['given_name'] ?? 'User Google';

if (!$google_id || !$email) {
    echo "Data user tidak lengkap.";
    exit;
}

// Cek apakah user sudah ada
$stmt = $conn->prepare("
    SELECT id, full_name, email
    FROM users
    WHERE provider = 'google' AND provider_id = ?
");
$stmt->bind_param("s", $google_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    // Kalau belum ada, buat user baru (auto "register" via Google)
    $stmt->close();
    $stmt = $conn->prepare("
        INSERT INTO users (full_name, email, provider, provider_id)
        VALUES (?, ?, 'google', ?)
    ");
    $stmt->bind_param("sss", $name, $email, $google_id);
    $stmt->execute();
    $user_id = $stmt->insert_id;
} else {
    $stmt->bind_result($user_id, $full_name, $email_db);
    $stmt->fetch();
    $name  = $full_name;
    $email = $email_db;
}

$_SESSION['user_id']    = $user_id;
$_SESSION['user_name']  = $name;
$_SESSION['user_email'] = $email;

header("Location: profile.php");
exit;
