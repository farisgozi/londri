<?php 
    include 'koneksi.php';
    $id_paket = $_POST['id_paket'];
    $id_outlet = $_POST['id_outlet'];
    $jenis = $_POST['jenis'];
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];

        // Validate required fields
        if(empty($id_outlet) || empty($jenis) || empty($nama_paket) || empty($harga)) {
            echo "<script>alert('Semua field harus diisi');location.href='paket.php';</script>";
            exit;
        }
    
        // Validate jenis enum
        $valid_jenis = ['kiloan', 'selimut', 'bed_cover', 'kaos', 'lain'];
        if(!in_array($jenis, $valid_jenis)) {
            echo "<script>alert('Jenis paket tidak valid');location.href='paket.php';</script>";
            exit;
        }
    
        // Validate harga as positive integer
        if(!is_numeric($harga) || $harga <= 0 || floor($harga) != $harga) {
            echo "<script>alert('Harga harus berupa bilangan bulat positif');location.href='paket.php';</script>";
            exit;
        }

            // Verify if outlet exists
        $check_outlet = mysqli_query($conn, "SELECT id_outlet FROM outlet WHERE id_outlet = '$id_outlet'");
        if(mysqli_num_rows($check_outlet) == 0) {
            echo "<script>alert('Outlet tidak ditemukan');location.href='paket.php';</script>";
            exit;
        }

    
        // Check if package already exists for the outlet
        $check_package = mysqli_query($conn, "SELECT * FROM paket WHERE id_outlet = '$id_outlet' AND nama_paket = '$nama_paket'");
        if(mysqli_num_rows($check_package) > 0) {
            echo "<script>alert('Paket dengan nama yang sama sudah ada di outlet ini');location.href='paket.php';</script>";
            exit;
        }

    $sql = "
        update paket set id_outlet = '" . $id_outlet . "', jenis = '" . $jenis . "', nama_paket = '" . $nama_paket . "', harga = '" . $harga . "'
        where id_paket = '" . $id_paket . "';
    ";

    $result = mysqli_query($conn, $sql);
        if($result){
            echo "Success edit paket";
        }else{
            echo "Failed edit paket";
        }
?>