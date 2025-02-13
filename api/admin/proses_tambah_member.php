<?php
if($_POST){
    $nama_member = htmlspecialchars(trim($_POST['nama_member']));
    $alamat = htmlspecialchars(trim($_POST['alamat']));
    $jenis_kelamin = htmlspecialchars(trim($_POST['jenis_kelamin']));
    $tlp = htmlspecialchars(trim($_POST['tlp']));

    // Validate phone number format
    if(!preg_match("/^[0-9]{10,15}$/", $tlp)) {
        echo "<script>alert('Format nomor telepon tidak valid. Gunakan 10-15 digit angka.');location.href='member.php';</script>";
        exit;
    }

    if(empty($nama_member)){
        echo "<script>alert('Nama member tidak boleh kosong');location.href='member.php';</script>";
    } elseif(empty($tlp)){
        echo "<script>alert('No Telp tidak boleh kosong');location.href='member.php';</script>";
    } else {
        include "koneksi.php";
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO member (nama_member, alamat, jenis_kelamin, tlp) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama_member, $alamat, $jenis_kelamin, $tlp);
        
        if($stmt->execute()){
            echo "<script>alert('Sukses menambahkan member');location.href='member.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan member: " . $stmt->error . "');location.href='member.php';</script>";
        }
        $stmt->close();
    }
}
?>