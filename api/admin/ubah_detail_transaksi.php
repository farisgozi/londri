<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Detail Transaksi | Laundries</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
    <link href="../assets/plugins/fontawesome/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white" style="width: 280px; min-height: 100vh;">
            <div class="p-4">
                <div class="text-center mb-4">
                    <img src="../logos.webp" alt="Logo" class="img-fluid mb-3" style="max-height: 60px;">
                    <h5 class="mb-0">Laundries</h5>
                </div>

                <!-- Navigation Menu -->
                <nav class="mt-4">
                    <div class="mb-3">
                        <small class="text-muted text-uppercase">Menu Kasir</small>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="./index_admin.php" class="nav-link text-white">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="transaksi.php" class="nav-link text-white">
                                <i class="fas fa-cash-register me-2"></i> Transaksi
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="member.php" class="nav-link text-white">
                                <i class="fas fa-users me-2"></i> Pelanggan
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="paket.php" class="nav-link text-white active">
                                <i class="fas fa-box me-2"></i> Paket Laundry
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="outlet.php" class="nav-link text-white">
                                <i class="fas fa-store me-2"></i> Outlet
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="user.php" class="nav-link text-white">
                                <i class="fas fa-user-cog me-2"></i> User
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link text-white">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Ubah Detail Transaksi</span>
                </div>
            </nav>

            <!-- Content -->
            <div class="container-fluid p-4">
                <div class="card">
                    <div class="card-body">
                        <?php 
                        include "koneksi.php";
                        $sql = 'select * from transaksi join detail_transaksi on detail_transaksi.id_transaksi=transaksi.id_transaksi where detail_transaksi.id_detail_transaksi = ' . $_GET['id_detail_transaksi'];
                        $result = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_assoc($result);
                        ?>

                        <form action="proses_ubah_detail_transaksi.php" method="post">
                            <div class="mb-3">
                                <label class="form-label">Status Pembayaran <span class="text-danger">*</span></label>
                                <select name="dibayar" class="form-select" required>
                                    <option value="dibayar" <?php echo ($data['dibayar'] == 'dibayar') ? 'selected' : ''; ?>>Dibayar</option>
                                    <option value="belum dibayar" <?php echo ($data['dibayar'] == 'belum dibayar') ? 'selected' : ''; ?>>Belum Dibayar</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Bayar <span class="text-muted">(Jika Status Pembayaran "Dibayar")</span></label>
                                <input type="date" class="form-control" name="tgl_bayar" value="<?php echo $data['tgl_bayar']; ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status Order <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="baru" <?php echo ($data['status'] == 'baru') ? 'selected' : ''; ?>>Baru</option>
                                    <option value="proses" <?php echo ($data['status'] == 'proses') ? 'selected' : ''; ?>>Proses</option>
                                    <option value="selesai" <?php echo ($data['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                    <option value="diambil" <?php echo ($data['status'] == 'diambil') ? 'selected' : ''; ?>>Diambil</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah (kg) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="qty" value="<?php echo $data['qty']; ?>" required>
                            </div>

                            <input type="hidden" name="id_transaksi" value="<?php echo $data['id_transaksi']; ?>">
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="detail_transaksi.php?id_transaksi=<?php echo $data['id_transaksi']; ?>" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
