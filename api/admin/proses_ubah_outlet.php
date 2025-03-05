<?php 
    include 'koneksi.php';

    $id_outlet = $_POST['id_outlet'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tlp = $_POST['tlp'];

                // Validate required fields
                if(empty($id_outlet) || empty($nama) || empty($alamat) || empty($tlp)) {
                    echo "<script>alert('Semua field harus diisi');location.href='outlet.php';</script>";
                    exit;
                }
        
                // Verify if nama member already exists
                $check_namaoutlet = mysqli_query($conn, "SELECT id_outlet FROM outlet WHERE id_outlet = '$id_outlet'");
                if(mysqli_num_rows($check_namaoutlet) == 0) {
                    echo "<script>alert('Member tidak ditemukan');location.href='outlet.php';</script>";
                    exit;
                }
    
                // Check if the new name already exists for a different member
                $check_nama = mysqli_query($conn, "SELECT id_outlet FROM outlet WHERE nama = '$nama' AND id_outlet != '$id_outlet'");
                if(mysqli_num_rows($check_nama) > 0) {
                    echo "Nama Outlet sudah ada. Gunakan nama lain";
                    exit;
                }

    $sql = "
        update outlet set nama = '" . $nama . "', alamat = '" . $alamat . "', tlp = '" . $tlp . "'
        where id_outlet = '" . $id_outlet . "';
    ";

    $result = mysqli_query($conn, $sql);
        if($result){
            echo "Success edit outlet";
        }else{
            echo "Failed edit outlet";
        }
?>