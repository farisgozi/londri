<?php
$host = "localhost";
$user = "gozi";
$pass = "1503";
$db   = "aplikasilaundry";

$conn = mysqli_connect($host,$user,$pass,$db);

if (!$conn) {
    die("Koneksi gagal:".mysqli_connect_error());
}

// Set MySQL mode to allow invalid dates
mysqli_query($conn, "SET sql_mode = ''");
?>
