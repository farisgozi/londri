<?php
    include "koneksi.php";
    $query = mysqli_query($conn, "SELECT username FROM user");
    $usernames = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $usernames[] = $row['username'];
    }
    echo json_encode($usernames);
?>