<?php 
    include 'koneksi.php';
    $id_user = $_POST['id_user'];
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $password=md5($_POST['password']);
    $id_outlet = $_POST['id_outlet'];
    $role = $_POST['role'];

                // Validate required fields
                if(empty($id_user) || empty($nama_user) || empty($username) || empty($password) || empty($id_outlet) || empty($role)) {
                    echo "<script>alert('Semua field harus diisi');location.href='user.php';</script>";
                    exit;
                }
        
                    // Verify if nama member already exists
                $check_user = mysqli_query($conn, "SELECT id_user FROM user WHERE id_user = '$id_user'");
                if(mysqli_num_rows($check_user) == 0) {
                    echo "<script>alert('User tidak ditemukan');location.href='user.php';</script>";
                    exit;
                }
    
                // Check if the new name already exists for a different member
                $check_username = mysqli_query($conn, "SELECT id_user FROM user WHERE username = '$username' AND id_user != '$id_user'");
                if(mysqli_num_rows($check_username) > 0) {
                    echo "Username sudah ada. Gunakan Username lain";
                    exit;
                }

    $sql = "
        update user set nama_user = '" . $nama_user . "', username = '" . $username . "', password = '" . $password . "', id_outlet = '" . $id_outlet . "', role = '" . $role . "'
        where id_user = '" . $id_user . "';
    ";

    $result = mysqli_query($conn, $sql);
        if($result){
            echo "Success edit user";
        }else{
            echo "Failed edit user";
        }
?>