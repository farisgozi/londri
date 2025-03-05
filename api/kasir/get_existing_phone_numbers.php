<?php
    include "koneksi.php";
    $query = mysqli_query($conn, "SELECT tlp FROM member");
    $phoneNumbers = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $phoneNumbers[] = $row['tlp'];
    }
    echo json_encode($phoneNumbers);
?>