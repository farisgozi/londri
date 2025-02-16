<?php
include "koneksi.php";
session_start();
if(!isset($_SESSION['id_user'])){
    header('location:../login.php');
    exit;
}

// Get current date in Y-m-d format
$current_date = date('Y-m-d');
$default_batas_waktu = date('Y-m-d', strtotime('+3 days'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaksi | Launnres</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
    <link href="../assets/plugins/fontawesome/css/all.min.css" rel="stylesheet">
<body>
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
                            <a href="index_kasir.php" class="nav-link text-white">
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
                    <span class="navbar-brand mb-0 h1">Transaksi Laundry</span>
                </div>
            </nav>

            <!-- Content -->
            <div class="container-fluid p-4">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Transaksi</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                            <i class="fas fa-plus me-2"></i>Tambah Transaksi
                        </button>
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
                                        <th>Status Bayar</th>
                                        <th>Customer</th>
                                        <th>Paket</th>
                                        <th>Harga/Kg</th>
                                        <th>Subtotal</th>
                                        <th>Diskon</th>
                                        <th>Pajak</th>
                                        <th>Total</th>
                                        <th>Status Order</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry_transaksi = mysqli_query($conn, "SELECT t.*, o.nama as outlet_nama, m.nama_member, p.nama_paket, p.harga, dt.qty,
                                                                        COALESCE(t.diskon, 0) as diskon,
                                                                        COALESCE(t.pajak, 0) as pajak
                                                                        FROM transaksi t
                                                                        JOIN outlet o ON t.id_outlet = o.id_outlet
                                                                        JOIN member m ON t.id_member = m.id_member
                                                                        JOIN paket p ON t.id_paket = p.id_paket
                                                                        LEFT JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
                                                                        ORDER BY t.tgl DESC");
                                    
                                    if (!$qry_transaksi) {
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                    $no = 1;
                                    while($data = mysqli_fetch_array($qry_transaksi)){
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data['outlet_nama']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($data['tgl'])); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($data['batas_waktu'])); ?></td>
                                        <td>
                                            <span class="badge <?php echo $data['dibayar'] == 'dibayar' ? 'bg-success' : 'bg-danger'; ?>">
                                                <?php echo ucfirst($data['dibayar']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $data['nama_member']; ?></td>
                                        <td><?php echo $data['nama_paket']; ?> (<?php echo $data['qty']; ?> pcs)</td>
                                        <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                                        <?php
                                        $subtotal = $data['harga'] * $data['qty'];
                                        $diskon_amount = $subtotal * ($data['diskon'] / 100);
                                        $after_diskon = $subtotal - $diskon_amount;
                                        $pajak_amount = $after_diskon * ($data['pajak'] / 100);
                                        $total = $after_diskon + $pajak_amount;
                                        ?>
                                        <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                                        <td><?php echo $data['diskon']; ?>% (Rp <?php echo number_format($diskon_amount, 0, ',', '.'); ?>)</td>
                                        <td><?php echo $data['pajak']; ?>% (Rp <?php echo number_format($pajak_amount, 0, ',', '.'); ?>)</td>
                                        <td>Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                                        <td>
                                            <?php
                                            $status_class = '';
                                            switch($data['status']) {
                                                case 'baru':
                                                    $status_class = 'bg-info';
                                                    break;
                                                case 'proses':
                                                    $status_class = 'bg-warning';
                                                    break;
                                                case 'selesai':
                                                    $status_class = 'bg-success';
                                                    break;
                                                case 'diambil':
                                                    $status_class = 'bg-primary';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?php echo $status_class; ?>">
                                                <?php echo ucfirst($data['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="detail_transaksi.php?id_transaksi=<?php echo $data['id_transaksi']?>" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="hapus_transaksi.php?id_transaksi=<?php echo $data['id_transaksi']?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Apakah anda yakin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
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

    <!-- Add Transaction Modal -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Transaksi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="proses_tambah_transaksi.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Outlet</label>
                                <select name="id_outlet" class="form-select" required>
                                    <option value="">Pilih Outlet</option>
                                    <?php
                                    $qry_outlet = mysqli_query($conn, "SELECT * FROM outlet ORDER BY nama");
                                    while($outlet = mysqli_fetch_array($qry_outlet)){
                                        echo "<option value='".$outlet['id_outlet']."'>".$outlet['nama']." - ".$outlet['alamat']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pelanggan</label>
                                <select name="id_member" class="form-select" required>
                                    <option value="">Pilih Pelanggan</option>
                                    <?php
                                    $qry_member = mysqli_query($conn, "SELECT * FROM member ORDER BY nama_member");
                                    while($member = mysqli_fetch_array($qry_member)){
                                        echo "<option value='".$member['id_member']."'>".$member['nama_member']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Order</label>
                                <input type="date" name="tgl" class="form-control" value="<?php echo $current_date; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Batas Waktu</label>
                                <input type="date" name="batas_waktu" class="form-control" value="<?php echo $default_batas_waktu; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Paket Laundry</label>
                                <select name="id_paket" class="form-select" required>
                                    <option value="">Pilih Paket</option>
                                    <?php
                                    $qry_paket = mysqli_query($conn, "SELECT * FROM paket ORDER BY nama_paket");
                                    while($paket = mysqli_fetch_array($qry_paket)){
                                        echo "<option value='".$paket['id_paket']."'>".$paket['nama_paket']." - ".$paket['jenis']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jumlah (Qty)</label>
                                <input type="number" name="qty" class="form-control" value="1" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Diskon (%)</label>
                                <input type="number" name="diskon" class="form-control" value="0" min="0" max="100" step="0.01">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pajak (%)</label>
                                <input type="number" name="pajak" class="form-control" value="0" min="0" max="100" step="0.01">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan tambahan (opsional)"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Order</label>
                                <select name="status" class="form-select" required>
                                    <option value="baru">Baru</option>
                                    <option value="proses">Proses</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="diambil">Diambil</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Pembayaran</label>
                                <select name="dibayar" class="form-select" required onchange="toggleTglBayar(this.value)">
                                    <option value="belum dibayar">Belum Dibayar</option>
                                    <option value="dibayar">Dibayar</option>
                                </select>
                            </div>
                            <div class="col-md-12" id="tglBayarContainer" style="display: none;">
                                <label class="form-label">Tanggal Pembayaran</label>
                                <input type="date" name="tgl_bayar" class="form-control" value="<?php echo $current_date; ?>">
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleTglBayar(value) {
        const tglBayarContainer = document.getElementById('tglBayarContainer');
        tglBayarContainer.style.display = value === 'dibayar' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const dibayarSelect = document.querySelector('select[name="dibayar"]');
        toggleTglBayar(dibayarSelect.value);
        
        dibayarSelect.addEventListener('change', function() {
            toggleTglBayar(this.value);
        });
    });
    </script>
</body>
</html>