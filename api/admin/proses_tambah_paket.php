<?php
if($_POST){
    $id_outlet = filter_var($_POST['id_outlet'], FILTER_VALIDATE_INT);
    $jenis = htmlspecialchars(trim($_POST['jenis']));
    $nama_paket = htmlspecialchars(trim($_POST['nama_paket']));
    $harga = filter_var($_POST['harga'], FILTER_VALIDATE_FLOAT);

    if(!$id_outlet) {
        echo "<script>alert('ID Outlet tidak valid');location.href='paket.php';</script>";
        exit;
    }

    if($harga === false || $harga <= 0) {
        echo "<script>alert('Harga harus berupa angka positif');location.href='paket.php';</script>";
        exit;
    }

    if(empty($jenis)){
        echo "<script>alert('Jenis paket tidak boleh kosong');location.href='paket.php';</script>";
    } elseif(empty($nama_paket)){
        echo "<script>alert('Nama paket tidak boleh kosong');location.href='paket.php';</script>";
    } else {
        include "koneksi.php";
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO paket (id_outlet, jenis, nama_paket, harga) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $id_outlet, $jenis, $nama_paket, $harga);
        
        if($stmt->execute()){
            echo "<script>alert('Sukses menambahkan paket');location.href='paket.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan paket: " . $stmt->error . "');location.href='paket.php';</script>";
        }
        $stmt->close();
    }
}
?>