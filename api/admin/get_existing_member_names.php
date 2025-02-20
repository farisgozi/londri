<?php
    include "koneksi.php";
    $query = mysqli_query($conn, "SELECT nama_member FROM member");
    $memberNames = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $memberNames[] = $row['nama_member'];
    }
    echo json_encode($memberNames);
?>
