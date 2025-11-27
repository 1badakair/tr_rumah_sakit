<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "anahita_hospitals";

$connection = mysqli_connect($host, $username, $password, $database);

if(!$connection) {
    die("Koneksi Gagal: ". mysqli_connect_error());
}
?>