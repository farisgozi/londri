<?php
if($_POST){
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $id_outlet = $_POST['id_outlet'];
    $role = $_POST['role'];

    // Validate role enum
    $valid_roles = ['admin', 'kasir', 'owner'];
    if(!in_array($role, $valid_roles)) {
        echo "<script>alert('Role tidak valid');location.href='user.php';</script>";
        exit;
    }

    if(empty($username)){
        echo "<script>alert('Username tidak boleh kosong');location.href='user.php';</script>";
    } elseif(empty($_POST['password'])){
        echo "<script>alert('Password tidak boleh kosong');location.href='user.php';</script>";
    } else {
        include "koneksi.php";
        
        // Check if username already exists
        $check = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
        if(mysqli_num_rows($check) > 0) {
            echo "<script>alert('Username sudah digunakan');location.href='user.php';</script>";
            exit;
        }
        
        $insert = mysqli_query($conn, "INSERT INTO user (nama_user, username, password, id_outlet, role) 
        VALUES ('$nama_user','$username','$password','$id_outlet','$role')") or
        die(mysqli_error($conn));
        if($insert){
            echo "<script>alert('Sukses menambahkan user');location.href='user.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan user');location.href='user.php';</script>";
        }
    }
}
?>