<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /tr_rumah_sakit/public/login.php");
    exit;
}
