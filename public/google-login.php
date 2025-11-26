<?php
// public/google-login.php
session_start();

$client_id     = "GOOGLE_CLIENT_ID_KAMU";
$redirect_uri  = "http://localhost/public/google-callback.php";
$scope        = urlencode("email profile");
$response_type = "code";

$auth_url = "https://accounts.google.com/o/oauth2/v2/auth" .
    "?client_id={$client_id}" .
    "&redirect_uri=" . urlencode($redirect_uri) .
    "&response_type={$response_type}" .
    "&scope={$scope}" .
    "&access_type=offline" .
    "&prompt=select_account";

header("Location: $auth_url");
exit;
