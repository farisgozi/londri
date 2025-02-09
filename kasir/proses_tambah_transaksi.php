<?php
include "koneksi.php";

if($_POST){
    $id_member = isset($_POST['id_member']) ? $_POST['id_member'] : null;
    $id_outlet = isset($_POST['id_outlet']) ? $_POST['id_outlet'] : null;
    $id_paket = isset($_POST['id_paket']) ? $_POST['id_paket'] : null;
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : '';
    
    session_start();
    $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
    
    // Get dates
    $tgl = isset($_POST['tgl']) ? $_POST['tgl'] : date('Y-m-d');
    $batas_waktu = isset($_POST['batas_waktu']) ? $_POST['batas_waktu'] : date('Y-m-d', strtotime('+3 days'));
    
    $status = isset($_POST['status']) ? $_POST['status'] : 'baru';
    $dibayar = isset($_POST['dibayar']) ? $_POST['dibayar'] : 'belum dibayar';
    
    // Set tgl_bayar based on payment status
    $tgl_bayar = ($dibayar == 'dibayar') ? date('Y-m-d') : '';

    if(empty($id_member)){
        echo "<script>alert('Id member tidak boleh kosong');location.href='transaksi.php';</script>";
    } elseif(empty($id_user)){
        echo "<script>alert('Sesi user tidak valid. Silakan login ulang');location.href='../login.php';</script>";
    } elseif(empty($id_outlet)){
        echo "<script>alert('Id outlet tidak boleh kosong');location.href='transaksi.php';</script>";
    } elseif(empty($id_paket)){
        echo "<script>alert('Id paket tidak boleh kosong');location.href='transaksi.php';</script>";
    } else {
        // Insert into transaksi table
        $insert = mysqli_query($conn, 
            "INSERT INTO transaksi (id_outlet, id_member, tgl, batas_waktu, tgl_bayar, status, dibayar, id_user, id_paket) 
             VALUES ('$id_outlet', '$id_member', '$tgl', '$batas_waktu', " . 
             ($dibayar == 'dibayar' ? "'$tgl_bayar'" : "NULL") . 
             ", '$status', '$dibayar', '$id_user', '$id_paket')"
        );
        
        if($insert){
            $id_transaksi = mysqli_insert_id($conn);
            
            // Insert into detail_transaksi table
            $insert_detail = mysqli_query($conn, 
                "INSERT INTO detail_transaksi (id_transaksi, id_paket, qty, keterangan) 
                 VALUES ('$id_transaksi', '$id_paket', '$qty', '$keterangan')"
            );
            
            if($insert_detail){
                echo "<script>alert('Sukses menambahkan transaksi');location.href='transaksi.php';</script>";
            } else {
                mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'");
                echo "<script>alert('Gagal menambahkan detail transaksi');location.href='transaksi.php';</script>";
            }
        } else {
            echo "<script>alert('Gagal menambahkan transaksi');location.href='transaksi.php';</script>";
        }
    }
}
?>
