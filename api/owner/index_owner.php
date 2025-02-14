<?php
include "koneksi.php";

// Get total transactions
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi");
$total_transaksi = mysqli_fetch_assoc($result)['total'];

// Get total revenue
$result = mysqli_query($conn, "SELECT SUM(p.harga) as total FROM transaksi t JOIN paket p ON t.id_paket = p.id_paket WHERE t.dibayar = 'dibayar'");
$total_revenue = mysqli_fetch_assoc($result)['total'];

// Get total customers
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM member");
$total_customers = mysqli_fetch_assoc($result)['total'];

// Get total outlets
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM outlet");
$total_outlets = mysqli_fetch_assoc($result)['total'];

// Get monthly revenue data
$monthly_revenue = mysqli_query($conn, "SELECT 
    DATE_FORMAT(t.tgl, '%Y-%m') as month,
    SUM(p.harga) as revenue
    FROM transaksi t 
    JOIN paket p ON t.id_paket = p.id_paket 
    WHERE t.dibayar = 'dibayar'
    GROUP BY DATE_FORMAT(t.tgl, '%Y-%m')
    ORDER BY month DESC
    LIMIT 6");

// Get transaction status distribution
$status_dist = mysqli_query($conn, "SELECT status, COUNT(*) as count FROM transaksi GROUP BY status");

// Get top performing outlets
$top_outlets = mysqli_query($conn, "SELECT 
    o.nama as outlet_name,
    COUNT(*) as transaction_count,
    SUM(p.harga) as revenue
    FROM transaksi t 
    JOIN outlet o ON t.id_outlet = o.id_outlet
    JOIN paket p ON t.id_paket = p.id_paket
    WHERE t.dibayar = 'dibayar'
    GROUP BY o.id_outlet
    ORDER BY revenue DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Owner | LaundryApp</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
    <link href="../assets/plugins/fontawesome/css/all.min.css" rel="stylesheet">
    <script src="../assets/plugins/chartjs/chart.js"></script>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white" style="width: 280px; min-height: 100vh;">
            <div class="p-4">
                <div class="text-center mb-4">
                    <img src="../logos.webp" alt="Logo" class="img-fluid mb-3" style="max-height: 60px;">
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
                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Transaksi</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_transaksi) ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pendapatan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($total_revenue) ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pelanggan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_customers) ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Outlet</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_outlets) ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-store fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row mb-4">
                    <!-- Monthly Revenue Chart -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Pendapatan Bulanan</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Status Distribution Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Distribusi Status Transaksi</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi Terbaru</h6>
                        <a href="cetak_transaksi.php" class="btn btn-sm btn-primary">
                            <i class="fas fa-print me-2"></i>Cetak Laporan
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Outlet</th>
                                        <th>Tanggal</th>
                                        <th>Customer</th>
                                        <th>Paket</th>
                                        <th>Status</th>
                                        <th>Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry_transaksi = mysqli_query($conn, "SELECT t.*, o.nama as nama_outlet, m.nama_member, p.nama_paket 
                                                                        FROM transaksi t 
                                                                        JOIN outlet o ON t.id_outlet = o.id_outlet 
                                                                        JOIN member m ON t.id_member = m.id_member 
                                                                        JOIN paket p ON t.id_paket = p.id_paket 
                                                                        ORDER BY t.tgl DESC LIMIT 10");
                                    $no = 0;
                                    while($data_transaksi = mysqli_fetch_array($qry_transaksi)){
                                        $no++;
                                    ?>
                                    <tr>
                                        <td><?=$no?></td>
                                        <td><?=$data_transaksi['nama_outlet']?></td>
                                        <td><?=$data_transaksi['tgl']?></td>
                                        <td><?=$data_transaksi['nama_member']?></td>
                                        <td><?=$data_transaksi['nama_paket']?></td>
                                        <td>
                                            <span class="badge bg-info"><?=$data_transaksi['status']?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?=$data_transaksi['dibayar']=='dibayar'?'success':'warning'?>">
                                                <?=$data_transaksi['dibayar']?>
                                            </span>
                                        </td>
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
    <script>
        // Monthly Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: [<?php 
                    $labels = [];
                    $data = [];
                    while($row = mysqli_fetch_assoc($monthly_revenue)) {
                        $labels[] = "'" . date('M Y', strtotime($row['month'])) . "'";
                        $data[] = $row['revenue'];
                    }
                    echo implode(',', array_reverse($labels));
                ?>],
                datasets: [{
                    label: 'Pendapatan Bulanan',
                    data: [<?php echo implode(',', array_reverse($data)); ?>],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Status Distribution Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: [<?php 
                    $labels = [];
                    $data = [];
                    while($row = mysqli_fetch_assoc($status_dist)) {
                        $labels[] = "'" . $row['status'] . "'";
                        $data[] = $row['count'];
                    }
                    echo implode(',', $labels);
                ?>],
                datasets: [{
                    data: [<?php echo implode(',', $data); ?>],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 206, 86)',
                        'rgb(75, 192, 192)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>