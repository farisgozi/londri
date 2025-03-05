<?php
    include 'koneksi.php';

    $id_member = $_POST['id_member'];
    $nama_member = $_POST['nama_member'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tlp = $_POST['tlp'];

            // Validate required fields
            if(empty($id_member) || empty($nama_member) || empty($alamat) || empty($jenis_kelamin) || empty($tlp)) {
                echo "<script>alert('Semua field harus diisi');location.href='member.php';</script>";
                exit;
            }
        
            // Validate jenis enum
            $valid_jenis = ['Laki-laki', 'Perempuan'];
            if(!in_array($jenis_kelamin, $valid_jenis)) {
                echo "<script>alert('Jenis kelamin tidak valid');location.href='member.php';</script>";
                exit;
            }
    
                // Verify if nama member already exists
            $check_member = mysqli_query($conn, "SELECT id_member FROM member WHERE id_member = '$id_member'");
            if(mysqli_num_rows($check_member) == 0) {
                echo "<script>alert('Member tidak ditemukan');location.href='member.php';</script>";
                exit;
            }

            // Check if the new name already exists for a different member
            $check_nama = mysqli_query($conn, "SELECT id_member FROM member WHERE nama_member = '$nama_member' AND id_member != '$id_member'");
            if(mysqli_num_rows($check_nama) > 0) {
                echo "Nama member sudah ada. Gunakan nama lain";
                exit;
            }
    

    
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
