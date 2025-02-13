<?php
if($_POST){
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id_outlet = $_POST['id_outlet'];
    $role = $_POST['role'];

    // Validate required fields
    if(empty($nama_user) || empty($username) || empty($password) || empty($id_outlet) || empty($role)) {
        echo "<script>alert('Semua field harus diisi');location.href='user.php';</script>";
        exit;
    }

    // Validate role enum
    $valid_roles = ['admin', 'kasir', 'owner'];
    if(!in_array($role, $valid_roles)) {
        echo "<script>alert('Role tidak valid');location.href='user.php';</script>";
        exit;
    }

    include "koneksi.php";
    
    // Check if username already exists
    $check = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if(mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username sudah digunakan');location.href='user.php';</script>";
        exit;
    }

    // Verify if outlet exists
    $check_outlet = mysqli_query($conn, "SELECT id_outlet FROM outlet WHERE id_outlet = '$id_outlet'");
    if(mysqli_num_rows($check_outlet) == 0) {
        echo "<script>alert('Outlet tidak ditemukan');location.href='user.php';</script>";
        exit;
    }

    // Hash password with MD5 as per existing implementation
    $hashed_password = md5($password);
    
    $insert = mysqli_query($conn, "INSERT INTO user (nama_user, username, password, id_outlet, role) 
    VALUES ('$nama_user','$username','$hashed_password','$id_outlet','$role')") or
    die(mysqli_error($conn));

    if($insert){
        echo "<script>alert('Sukses menambahkan user');location.href='user.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan user');location.href='user.php';</script>";
    }
}
?>