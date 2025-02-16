<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Kasir | Launners</title>
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
                    <h5 class="mb-0">Launners</h5>
                </div>

                <!-- Navigation Menu -->
                <nav class="mt-4">
                    <div class="mb-3">
                        <small class="text-muted text-uppercase">Menu Kasir</small>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="index_kasir.php" class="nav-link text-white active">
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
                    <span class="navbar-brand mb-0 h1">Dashboard Kasir</span>
                    <div class="d-flex align-items-center">
                        <span class="text-muted me-2">
                            <i class="fas fa-calendar-alt me-1"></i>
                            <?php echo date('d F Y'); ?>
                        </span>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <div class="container-fluid p-4">
                <?php include 'koneksi.php'; ?>
                
                <!-- Welcome Card -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-primary text-white">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="mb-1">Selamat Datang di Laundries</h4>
                                        <p class="mb-0">Kelola transaksi laundry dengan mudah dan efisien</p>
                                    </div>
                                    <i class="fas fa-tshirt fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row g-4 mb-4">
                    <!-- Member Stats -->
                    <div class="col-sm-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <?php
                                $data_member = mysqli_query($conn,"SELECT * FROM member");
                                $jumlah_member = mysqli_num_rows($data_member);
                                ?>
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-box">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="icon-box bg-success-subtle rounded p-2 me-2">
                                                <i class="fas fa-users text-success"></i>
                                            </div>
                                            <span class="text-muted">Pelanggan</span>
                                        </div>
                                        <h3 class="mb-0"><?php echo $jumlah_member; ?></h3>
                                        <small class="text-muted">Total Pelanggan Terdaftar</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Stats -->
                    <div class="col-sm-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <?php
                                $data_transaksi = mysqli_query($conn,"SELECT * FROM transaksi");
                                $jumlah_transaksi = mysqli_num_rows($data_transaksi);
                                ?>
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-box">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="icon-box bg-warning-subtle rounded p-2 me-2">
                                                <i class="fas fa-cash-register text-warning"></i>
                                            </div>
                                            <span class="text-muted">Transaksi</span>
                                        </div>
                                        <h3 class="mb-0"><?php echo $jumlah_transaksi; ?></h3>
                                        <small class="text-muted">Total Transaksi</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions & Recent Transactions -->
                <div class="row">
                    <!-- Quick Actions -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Aksi Cepat</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="transaksi.php" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Transaksi Baru
                                    </a>
                                    <a href="member.php" class="btn btn-success">
                                        <i class="fas fa-user-plus me-2"></i>Tambah Pelanggan
                                    </a>
                                    <a href="cetak_laporan.php" class="btn btn-info">
                                        <i class="fas fa-print me-2"></i>Cetak Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="col-md-8 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Transaksi Terbaru</h5>
                                <a href="transaksi.php" class="btn btn-sm btn-primary">
                                    Lihat Semua
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Pelanggan</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT t.*, m.nama_member, p.harga * dt.qty as total 
                                                                        FROM transaksi t 
                                                                        JOIN member m ON t.id_member = m.id_member 
                                                                        JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi 
                                                                        JOIN paket p ON t.id_paket = p.id_paket 
                                                                        ORDER BY t.tgl DESC LIMIT 5");
                                            while($data = mysqli_fetch_array($query)){
                                            ?>
                                            <tr>
                                                <td>#<?php echo $data['id_transaksi']; ?></td>
                                                <td><?php echo $data['nama_member']; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($data['tgl'])); ?></td>
                                                <td>
                                                    <?php
                                                    $status_class = '';
                                                    switch($data['status']) {
                                                        case 'baru':
                                                            $status_class = 'info';
                                                            break;
                                                        case 'proses':
                                                            $status_class = 'warning';
                                                            break;
                                                        case 'selesai':
                                                            $status_class = 'success';
                                                            break;
                                                        case 'diambil':
                                                            $status_class = 'primary';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="badge bg-<?php echo $status_class; ?>">
                                                        <?php echo ucfirst($data['status']); ?>
                                                    </span>
                                                </td>
                                                <td>Rp <?php echo number_format($data['total'], 0, ',', '.'); ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Overview -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Status Pesanan</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <?php
                                    $status_counts = array(
                                        'baru' => 0,
                                        'proses' => 0,
                                        'selesai' => 0,
                                        'diambil' => 0
                                    );
                                    
                                    $query = mysqli_query($conn, "SELECT status, COUNT(*) as count FROM transaksi GROUP BY status");
                                    while($data = mysqli_fetch_array($query)) {
                                        $status_counts[$data['status']] = $data['count'];
                                    }
                                    
                                    $status_info = array(
                                        'baru' => array('icon' => 'inbox', 'color' => 'info'),
                                        'proses' => array('icon' => 'sync', 'color' => 'warning'),
                                        'selesai' => array('icon' => 'check-circle', 'color' => 'success'),
                                        'diambil' => array('icon' => 'shopping-bag', 'color' => 'primary')
                                    );
                                    
                                    foreach($status_counts as $status => $count) {
                                        $info = $status_info[$status];
                                    ?>
                                    <div class="col-sm-6 col-xl-3">
                                        <div class="card bg-<?php echo $info['color']; ?>-subtle">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-<?php echo $info['color']; ?> p-3 rounded">
                                                            <i class="fas fa-<?php echo $info['icon']; ?> fa-fw text-white"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h4 class="mb-0"><?php echo $count; ?></h4>
                                                        <small class="text-muted">Pesanan <?php echo ucfirst($status); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>