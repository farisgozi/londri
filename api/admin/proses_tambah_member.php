<?php
if($_POST){
    $nama_member=$_POST['nama_member'];
    $alamat=$_POST['alamat'];
    $jenis_kelamin=$_POST['jenis_kelamin'];
    $tlp=$_POST['tlp'];

    if(empty($nama_member)){
        echo "<script>alert('Nama member tidak boleh kosong');location.href='member.php';</script>";
    } elseif(empty($tlp)){
        echo "<script>alert('No Telp tidak boleh kosong');location.href='member.php';</script>";
    } else {
        include "koneksi.php";
        $insert=mysqli_query($conn,"INSERT INTO member (nama_member, alamat, jenis_kelamin, tlp) 
        VALUES ('".$nama_member."','".$alamat."','".$jenis_kelamin."','".$tlp."')") or
        die(mysqli_error($conn));
        if($insert){
            echo "<script>alert('Sukses menambahkan member');location.href='member.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan member');location.href='member.php';</script>";
        }
    }
}
?>