<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | Aplikasi Laundry</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row vh-100 align-items-center justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <img src="../logos.webp" alt="Logo" class="img-fluid mb-3" style="max-height: 100px;">
                            <h4 class="text-dark mb-2">Selamat Datang</h4>
                            <p class="text-muted">Silahkan login untuk melanjutkan</p>
                        </div>

                        <?php
                        if(isset($_GET['alert'])){
                            if($_GET['alert']=="gagal"){
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                        Username atau Password salah!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                      </div>";
                            }else if($_GET['alert']=="belum_login"){
                                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                        Anda harus login terlebih dahulu!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                      </div>";
                            }else if($_GET['alert']=="logout"){
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        Anda telah berhasil logout
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                      </div>";
                            }
                        }
                        ?>

                        <form action="aksi.php" method="post">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Masukkan username" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Login
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="text-center mt-4">
                    <p class="text-muted">Launners &copy; 2025</p>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
