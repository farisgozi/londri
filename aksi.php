<?php 
// berfungsi mengaktifkan session
session_start();
 
// berfungsi menghubungkan koneksi ke database
include './admin/koneksi.php';
 
// berfungsi menangkap data yang dikirim
$user = $_POST['username'];
$pass = md5($_POST['password']);
 
// berfungsi menyeleksi data user dengan username dan password yang sesuai
$sql = mysqli_query($conn,"SELECT * FROM user WHERE username='$user' AND password='$pass'");
//berfungsi menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($sql);

// berfungsi mengecek apakah username dan password ada pada database
if($cek > 0){
    $data = mysqli_fetch_assoc($sql);

    // berfungsi mengecek jika user login sebagai admin
    if($data['role']=="admin"){
        // berfungsi membuat session
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama_user'];
        $_SESSION['role'] = "admin";
        $_SESSION['id_outlet'] = $data['id_outlet'];
        //berfungsi mengalihkan ke halaman admin
        header("location:index_admin.php");
    // berfungsi mengecek jika user login sebagai kasir
    }else if($data['role']=="kasir"){
        // berfungsi membuat session
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama_user'];
        $_SESSION['role'] = "kasir";
        $_SESSION['id_outlet'] = $data['id_outlet'];
        // berfungsi mengalihkan ke halaman kasir
        header("location:kasir/index_kasir.php");
    }else if($data['role']=="owner"){
        // berfungsi membuat session
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama_user'];
        $_SESSION['role'] = "owner";
        $_SESSION['id_outlet'] = $data['id_outlet'];
        // berfungsi mengalihkan ke halaman owner
        header("location:owner/index_owner.php");
    }else{
        // berfungsi mengalihkan alihkan ke halaman login kembali
        header("location:index.php?alert=gagal");
    }   
}else{
    header("location:login.php?alert=gagal");
}
?>