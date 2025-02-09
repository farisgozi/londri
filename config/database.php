<?php
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'gozi';
$pass = getenv('DB_PASS') ?: '1503';
$db   = getenv('DB_NAME') ?: 'aplikasilaundry';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>