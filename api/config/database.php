<?php
$host = 'localhost';
$user = 'gozi';
$pass = '1503';
$db   = 'aplikasilaundry';
$port = '3306';

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>