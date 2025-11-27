<?php
// public/index.php
// Halaman sederhana: tombol Login / Register
// Letakkan file ini di folder public (sama level dengan login.php / register.php)
require_once __DIR__ . "/../includes/init.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loggedIn = isset($_SESSION['user_id']);
$displayName = $_SESSION['user_name'] ?? '';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda — Rumah Sakit</title>
    <style>
        :root{--accent:#2b6cb0}
        body{font-family:system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; margin:0; padding:0; background:#f5f7fb; color:#111}
        .container{max-width:900px;margin:6vh auto;padding:2rem;background:#fff;border-radius:12px;box-shadow:0 6px 18px rgba(15,23,42,0.08)}
        header{display:flex;align-items:center;justify-content:space-between}
        h1{font-size:1.5rem;margin:0}
        p.lead{color:#555;margin:0.5rem 0 1.25rem}
        .actions{display:flex;gap:0.75rem;flex-wrap:wrap}
        a.btn{display:inline-block;padding:0.6rem 1rem;border-radius:8px;text-decoration:none;font-weight:600}
        .btn-primary{background:var(--accent);color:#fff}
        .btn-ghost{background:transparent;border:1px solid #e6eef7;color:var(--accent)}
        .card{padding:1rem;border-radius:10px;background:#fbfdff;border:1px solid #f0f6fb;margin-top:1rem}
        footer{margin-top:1.5rem;color:#666;font-size:.9rem}
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>Portal Rumah Sakit</h1>
        <?php if($loggedIn): ?>
            <div>
                Hello, <?= htmlspecialchars($displayName) ?>
            </div>
        <?php else: ?>
            <div>
                <a class="btn btn-ghost" href="login.php">Masuk</a>
                <a class="btn btn-primary" href="register.php">Daftar</a>
            </div>
        <?php endif; ?>
    </header>

    <p class="lead">Selamat datang — gunakan tombol di atas untuk masuk atau membuat akun. Kamu bisa menambahkan link lain (dokter, jadwal) nanti.</p>

    <div class="card">
        <?php if($loggedIn): ?>
            <h3>Akses Cepat</h3>
            <div class="actions">
                <a class="btn btn-primary" href="profile.php">Profil Saya</a>
                <a class="btn btn-ghost" href="change-password.php">Ganti Password</a>
                <a class="btn btn-ghost" href="logout.php">Logout</a>
            </div>
        <?php else: ?>
            <h3>Belum Punya Akun?</h3>
            <p>Daftar sekarang untuk membuat janji, melihat riwayat, dan mengakses layanan pasien.</p>
            <div class="actions">
                <a class="btn btn-primary" href="register.php">Daftar</a>
                <a class="btn btn-ghost" href="login.php">Sudah Punya Akun? Masuk</a>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <small>Versi pengembangan — jangan gunakan di produksi tanpa security hardening.</small>
    </footer>
</div>
</body>
</html>