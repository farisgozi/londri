<?php
    if($_GET['id_transaksi']){
        include "koneksi.php";
        $hapus_detail = mysqli_query($conn, "delete from detail_transaksi where id_transaksi = '".$_GET['id_transaksi']."'");
        $qry_hapus=mysqli_query($conn,"delete from transaksi where id_transaksi='".$_GET['id_transaksi']."'");
        if($qry_hapus && $hapus_detail){
            echo "<script>alert('Sukses Hapus Transaksi');location.href='transaksi.php';</script>";
        } else {
            echo "<script>alert('Gagal hapus Transaksi');location.href='transaksi.php';</script>";
        }
    }
?>
