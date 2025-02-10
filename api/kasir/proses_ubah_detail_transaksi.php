<?php 
    include 'koneksi.php';

    $dibayar = $_POST['dibayar'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $status = $_POST['status'];
    $qty = $_POST['qty'];
    $id_transaksi = $_POST['id_transaksi'];

    $sql = "
        update transaksi join detail_transaksi on detail_transaksi.id_transaksi = transaksi.id_transaksi set dibayar = '" . $dibayar . "', tgl_bayar = '" . $tgl_bayar . "', status = '" . $status . "', qty = '" . $qty . "' where transaksi.id_transaksi = '" . $id_transaksi . "'
    ";

    $result = mysqli_query($conn, $sql);
        if($result){
            echo "<script>alert('Success edit transaksi');location.href='transaksi.php';</script>";
        }else{
            echo "<script>alert('Failed edit transaksi');location.href='transaksi.php';</script>";
        }
?>
