<?php
$host = getenv('DB_HOST') ?: 'junction.proxy.rlwy.net';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: 'cRnXiGlJHfVnOHMvduUgHnKiiqEfhUCR';
$db   = getenv('DB_NAME') ?: 'railway';
$port = getenv('DB_PORT') ?: '29252';

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Disable SSL for Railway connection
mysqli_query($conn, "SET SESSION ssl = 0");
?>