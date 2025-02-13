<?php
if($_POST){
    $id_outlet = $_POST['id_outlet'];
    $jenis = $_POST['jenis'];
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];

    // Validate id_outlet
    if(empty($id_outlet) || !is_numeric($id_outlet)) {
        echo "<script>alert('ID Outlet harus diisi dengan angka');location.href='paket.php';</script>";
        exit;
    }

    // Validate jenis enum
    $valid_jenis = ['kiloan', 'selimut', 'bed_cover', 'kaos', 'lain'];
    if(!in_array($jenis, $valid_jenis)) {
        echo "<script>alert('Jenis paket tidak valid');location.href='paket.php';</script>";
        exit;
    }

    // Validate harga as integer
    if(!is_numeric($harga) || $harga <= 0) {
        echo "<script>alert('Harga harus berupa angka positif');location.href='paket.php';</script>";
        exit;
    }

    if(empty($jenis)){
        echo "<script>alert('Jenis paket tidak boleh kosong');location.href='paket.php';</script>";
    } elseif(empty($nama_paket)){
        echo "<script>alert('Nama paket tidak boleh kosong');location.href='paket.php';</script>";
    } else {
        include "koneksi.php";
        
        // Verify if outlet exists
        $check_outlet = mysqli_query($conn, "SELECT id_outlet FROM outlet WHERE id_outlet = '$id_outlet'");
        if(mysqli_num_rows($check_outlet) == 0) {
            echo "<script>alert('ID Outlet tidak ditemukan');location.href='paket.php';</script>";
            exit;
        }

        $insert = mysqli_query($conn, "INSERT INTO paket (id_outlet, jenis, nama_paket, harga) 
        VALUES ($id_outlet,'$jenis','$nama_paket',$harga)") or
        die(mysqli_error($conn));
        
        if($insert){
            echo "<script>alert('Sukses menambahkan paket');location.href='paket.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan paket');location.href='paket.php';</script>";
        }
    }
}
?>