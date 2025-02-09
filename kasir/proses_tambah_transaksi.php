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

    if(empty($id_member)){
        echo "<script>alert('Id member tidak boleh kosong');location.href='transaksi.php';</script>";
    } elseif(empty($id_user)){
        echo "<script>alert('Sesi user tidak valid. Silakan login ulang');location.href='../login.php';</script>";
    } elseif(empty($id_outlet)){
        echo "<script>alert('Id outlet tidak boleh kosong');location.href='transaksi.php';</script>";
    } elseif(empty($id_paket)){
        echo "<script>alert('Id paket tidak boleh kosong');location.href='transaksi.php';</script>";
    } else {
        try {
            // Start transaction
            mysqli_begin_transaction($conn);
            
            // Build query based on payment status
            if($dibayar == 'dibayar') {
                $query = "INSERT INTO transaksi (id_outlet, id_member, tgl, batas_waktu, tgl_bayar, status, dibayar, id_user, id_paket) 
                         VALUES (?, ?, ?, ?, CURRENT_DATE(), ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "iissssis", 
                    $id_outlet,
                    $id_member,
                    $tgl,
                    $batas_waktu,
                    $status,
                    $dibayar,
                    $id_user,
                    $id_paket
                );
            } else {
                $query = "INSERT INTO transaksi (id_outlet, id_member, tgl, batas_waktu, tgl_bayar, status, dibayar, id_user, id_paket) 
                         VALUES (?, ?, ?, ?, NULL, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "iissssis", 
                    $id_outlet,
                    $id_member,
                    $tgl,
                    $batas_waktu,
                    $status,
                    $dibayar,
                    $id_user,
                    $id_paket
                );
            }
            
            if ($stmt === false) {
                throw new Exception('Failed to prepare statement: ' . mysqli_error($conn));
            }
            
            $insert = mysqli_stmt_execute($stmt);
            
            if($insert){
                $id_transaksi = mysqli_insert_id($conn);
                
                // Insert into detail_transaksi table
                $detail_query = "INSERT INTO detail_transaksi (id_transaksi, id_paket, qty, keterangan) VALUES (?, ?, ?, ?)";
                $detail_stmt = mysqli_prepare($conn, $detail_query);
                
                if ($detail_stmt === false) {
                    throw new Exception('Failed to prepare detail statement: ' . mysqli_error($conn));
                }
                
                mysqli_stmt_bind_param($detail_stmt, "iiis", 
                    $id_transaksi, 
                    $id_paket, 
                    $qty, 
                    $keterangan
                );
                
                $insert_detail = mysqli_stmt_execute($detail_stmt);
                
                if($insert_detail){
                    mysqli_commit($conn);
                    echo "<script>alert('Sukses menambahkan transaksi');location.href='transaksi.php';</script>";
                } else {
                    throw new Exception('Failed to insert detail: ' . mysqli_error($conn));
                }
                mysqli_stmt_close($detail_stmt);
            } else {
                throw new Exception('Failed to insert transaction: ' . mysqli_error($conn));
            }
            mysqli_stmt_close($stmt);
            
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log("Error in transaction: " . $e->getMessage());
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');location.href='transaksi.php';</script>";
        }
    }
}
?>
