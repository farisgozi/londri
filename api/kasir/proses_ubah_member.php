<?php
    include 'koneksi.php';

    $id_member = $_POST['id_member'];
    $nama_member = $_POST['nama_member'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tlp = $_POST['tlp'];

    $sql = "
        update member set nama_member = '" . $nama_member . "', alamat = '" . $alamat . "', jenis_kelamin = '" . $jenis_kelamin . "', tlp = '" . $tlp . "'
        where id_member = '" . $id_member . "';
    ";

    $result = mysqli_query($conn, $sql);
    if($result){
        echo "Success edit member";
    }else{
        echo "Failed edit member";
        // printf('Failed sign up: ' . mysqli_error($conn));
    }
?>