<?php
    include "koneksi.php";
    $query = mysqli_query($conn, "SELECT nama FROM outlet");
    $outletNames = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $outletNames[] = $row['nama'];
    }
    echo json_encode($outletNames);
?>