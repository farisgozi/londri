<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Owner | LaundryApp</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white" style="width: 280px; min-height: 100vh;">
            <div class="p-4">
                <div class="text-center mb-4">
                    <img src="../admin/laundry.PNG" alt="Logo" class="img-fluid mb-3" style="max-height: 60px;">
                    <h5 class="mb-0">LaundryApp</h5>
                </div>

                <!-- Navigation Menu -->
                <nav class="mt-4">
                    <div class="mb-3">
                        <small class="text-muted text-uppercase">Menu Owner</small>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="index_owner.php" class="nav-link text-white active">
                                <i class="fas fa-home me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="cetak_transaksi.php" class="nav-link text-white">
                                <i class="fas fa-print me-2"></i> Generate Laporan
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
        <div class="flex-grow-1 bg-light">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Dashboard Owner</span>
                </div>
            </nav>

            <!-- Content -->
            <div class="container-fluid p-4">
                <div class="row mb-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h4>Selamat Datang di LaundryApp</h4>
                                <p class="text-muted">Anda login sebagai Owner. Silahkan kelola laporan transaksi laundry Anda.</p>
                                <a href="cetak_transaksi.php" class="btn btn-primary">
                                    <i class="fas fa-print me-2"></i>Cetak Laporan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Histori Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Outlet</th>
                                        <th>Tanggal</th>
                                        <th>Batas Waktu</th>
                                        <th>Pembayaran</th>
                                        <th>Status</th>
                                        <th>Customer</th>
                                        <th>Paket</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry_transaksi = mysqli_query($conn, "SELECT t.*, o.nama as nama_outlet, m.nama_member, p.nama_paket 
                                                                        FROM transaksi t 
                                                                        JOIN outlet o ON t.id_outlet = o.id_outlet 
                                                                        JOIN member m ON t.id_member = m.id_member 
                                                                        JOIN paket p ON t.id_paket = p.id_paket 
                                                                        ORDER BY t.tgl DESC");
                                    $no = 0;
                                    while($data_transaksi = mysqli_fetch_array($qry_transaksi)){
                                        $no++;
                                    ?>
                                    <tr>
                                        <td><?=$no?></td>
                                        <td><?=$data_transaksi['nama_outlet']?></td>
                                        <td><?=$data_transaksi['tgl']?></td>
                                        <td><?=$data_transaksi['batas_waktu']?></td>
                                        <td>
                                            <span class="badge bg-<?=$data_transaksi['dibayar']=='dibayar'?'success':'warning'?>">
                                                <?=$data_transaksi['dibayar']?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?=$data_transaksi['status']?></span>
                                        </td>
                                        <td><?=$data_transaksi['nama_member']?></td>
                                        <td><?=$data_transaksi['nama_paket']?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>