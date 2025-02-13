<?php
if($_POST){
    $nama_user = htmlspecialchars(trim($_POST['nama_user']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    $id_outlet = filter_var($_POST['id_outlet'], FILTER_VALIDATE_INT);
    $role = htmlspecialchars(trim($_POST['role']));

    // Validate password strength
    if (strlen($password) < 8) {
        echo "<script>alert('Password harus minimal 8 karakter');location.href='user.php';</script>";
        exit;
    }

    if(!$id_outlet) {
        echo "<script>alert('ID Outlet tidak valid');location.href='user.php';</script>";
        exit;
    }

    // Validate role
    $valid_roles = ['admin', 'kasir', 'owner'];
    if (!in_array($role, $valid_roles)) {
        echo "<script>alert('Role tidak valid');location.href='user.php';</script>";
        exit;
    }

    if(empty($username)){
        echo "<script>alert('Username tidak boleh kosong');location.href='user.php';</script>";
    } elseif(empty($password)){
        echo "<script>alert('Password tidak boleh kosong');location.href='user.php';</script>";
    } else {
        include "koneksi.php";
        
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id_user FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            echo "<script>alert('Username sudah digunakan');location.href='user.php';</script>";
            $stmt->close();
            exit;
        }
        $stmt->close();
        
        // Hash password using PASSWORD_DEFAULT (currently bcrypt)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO user (nama_user, username, password, id_outlet, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $nama_user, $username, $hashed_password, $id_outlet, $role);
        
        if($stmt->execute()){
            echo "<script>alert('Sukses menambahkan user');location.href='user.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan user: " . $stmt->error . "');location.href='user.php';</script>";
        }
        $stmt->close();
    }
}
?>