<?php
if($_POST){
    $id_outlet = $_POST['id_outlet'];
    $jenis = $_POST['jenis'];
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];

    // Validate required fields
    if(empty($id_outlet) || empty($jenis) || empty($nama_paket) || empty($harga)) {
        echo "<script>alert('Semua field harus diisi');location.href='paket.php';</script>";
        exit;
    }

    // Validate jenis enum
    $valid_jenis = ['kiloan', 'selimut', 'bed_cover', 'kaos', 'lain'];
    if(!in_array($jenis, $valid_jenis)) {
        echo "<script>alert('Jenis paket tidak valid');location.href='paket.php';</script>";
        exit;
    }

    // Validate harga as positive integer
    if(!is_numeric($harga) || $harga <= 0 || floor($harga) != $harga) {
        echo "<script>alert('Harga harus berupa bilangan bulat positif');location.href='paket.php';</script>";
        exit;
    }

    include "koneksi.php";
    
    // Verify if outlet exists
    $check_outlet = mysqli_query($conn, "SELECT id_outlet FROM outlet WHERE id_outlet = '$id_outlet'");
    if(mysqli_num_rows($check_outlet) == 0) {
        echo "<script>alert('Outlet tidak ditemukan');location.href='paket.php';</script>";
        exit;
    }

    // Insert the package
    $insert = mysqli_query($conn, "INSERT INTO paket (id_outlet, jenis, nama_paket, harga) 
    VALUES ('$id_outlet', '$jenis', '$nama_paket', '$harga')") or
    die(mysqli_error($conn));

    if($insert){
        echo "<script>alert('Sukses menambahkan paket');location.href='paket.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan paket');location.href='paket.php';</script>";
    }
}
?>