<?php
// includes/auth.php

// Pastikan session aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika user belum login → redirect ke login
if (!isset($_SESSION['user_id'])) {

    // Untuk menghindari error path di folder berbeda (admin / public)
    $basePath = "/tr_rumah_sakit/public/login.php";

    header("Location: $basePath");
    exit;
}