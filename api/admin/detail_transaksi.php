<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Transaksi | Laundriesp</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
    <link href="../assets/plugins/fontawesome/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white" style="width: 280px; min-height: 100vh;">
            <div class="p-4">
                <div class="text-center mb-4">
                    <img src="./logos.webp" alt="Logo" class="img-fluid mb-3" style="max-height: 60px;">
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
                            <a href="transaksi.php" class="nav-link text-white active">
                                <i class="fas fa-cash-register me-2"></i> Transaksi
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="member.php" class="nav-link text-white">
                                <i class="fas fa-users me-2"></i> Pelanggan
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="paket.php" class="nav-link text-white">
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
        <div class="flex-grow-1 bg-light">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Detail Transaksi</span>
                </div>
            </nav>

            <!-- Content -->
            <div class="container-fluid p-4">
                <?php
                include "koneksi.php";
                $id_transaksi = $_GET['id_transaksi'];
                $sql = "SELECT * FROM transaksi 
                        JOIN member ON member.id_member = transaksi.id_member 
                        JOIN outlet ON outlet.id_outlet = transaksi.id_outlet 
                        WHERE transaksi.id_transaksi = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $id_transaksi);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $data_transaksi = mysqli_fetch_assoc($result);
                ?>

                <!-- Action Buttons -->
                <div class="mb-4">
                    <a href="transaksi.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="cetak_transaksi.php?id_transaksi=<?=$data_transaksi['id_transaksi']?>" 
                       target="_blank" class="btn btn-primary">
                        <i class="fas fa-print me-2"></i>Cetak Transaksi
                    </a>
                </div>

                <!-- Transaction Details -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Pelanggan</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="35%">Nama</td>
                                        <td width="5%">:</td>
                                        <td><?=$data_transaksi['nama_member']?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><?=$data_transaksi['alamat']?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin</td>
                                        <td>:</td>
                                        <td><?=$data_transaksi['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'?></td>
                                    </tr>
                                    <tr>
                                        <td>Telepon</td>
                                        <td>:</td>
                                        <td><?=$data_transaksi['tlp']?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Transaksi</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="35%">ID Transaksi</td>
                                        <td width="5%">:</td>
                                        <td><?=$data_transaksi['id_transaksi']?></td>
                                    </tr>
                                    <tr>
                                        <td>Outlet</td>
                                        <td>:</td>
                                        <td><?=$data_transaksi['nama']?></td>
                                    </tr>
                                    <tr>
                                        <td>Status Pembayaran</td>
                                        <td>:</td>
                                        <td>
                                            <span class="badge bg-<?=$data_transaksi['dibayar'] == 'dibayar' ? 'success' : 'danger'?>">
                                                <?=ucfirst($data_transaksi['dibayar'])?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status Order</td>
                                        <td>:</td>
                                        <td>
                                            <?php
                                            $status_class = '';
                                            switch($data_transaksi['status']) {
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
                                            <span class="badge bg-<?=$status_class?>">
                                                <?=ucfirst($data_transaksi['status'])?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Batas Waktu</td>
                                        <td>:</td>
                                        <td><?=date('d/m/Y', strtotime($data_transaksi['batas_waktu']))?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Detail Order</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Order</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Paket Laundry</th>
                                        <th>Berat (Kg)</th>
                                        <th>Harga/Kg</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry_detail = mysqli_query($conn, "SELECT dt.*, p.nama_paket, p.harga, t.tgl, t.tgl_bayar
                                                                     FROM detail_transaksi dt
                                                                     JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
                                                                     JOIN paket p ON dt.id_paket = p.id_paket
                                                                    WHERE dt.id_transaksi = $id_transaksi");
                                    $no = 1;
                                    $total = 0;
                                    while($detail = mysqli_fetch_array($qry_detail)) {
                                        $subtotal = $detail['qty'] * $detail['harga'];
                                        $total += $subtotal;
                                    ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=date('d/m/Y', strtotime($detail['tgl']))?></td>
                                        <td><?=$detail['tgl_bayar'] ? date('d/m/Y', strtotime($detail['tgl_bayar'])) : '-'?></td>
                                        <td><?=$detail['nama_paket']?></td>
                                        <td><?=$detail['qty']?></td>
                                        <td>Rp <?=number_format($detail['harga'], 0, ',', '.')?></td>
                                        <td>Rp <?=number_format($subtotal, 0, ',', '.')?></td>
                                        <td>
                                            <a href="ubah_detail_transaksi.php?id_detail_transaksi=<?=$detail['id_detail_transaksi']?>" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr class="fw-bold">
                                        <td colspan="6" class="text-end">Total:</td>
                                        <td>Rp <?=number_format($total, 0, ',', '.')?></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
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
