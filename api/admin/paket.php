<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paket Laundry | Laundries</title>
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
                    <img src="../logos.webp" alt="Logo" class="img-fluid mb-3" style="max-height: 60px;">
                    <h5 class="mb-0">Laundries</h5>
                </div>

                <!-- Navigation Menu -->
                <nav class="mt-4">
                    <div class="mb-3">
                        <small class="text-muted text-uppercase">Menu Admin</small>
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
        <div class="flex-grow-1 bg-light">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Paket Laundry</span>
                </div>
            </nav>

            <!-- Content -->
            <div class="container-fluid p-4">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Paket Laundry</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaketModal">
                            <i class="fas fa-plus me-2"></i>Tambah Paket
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Paket</th>
                                        <th>Jenis</th>
                                        <th>Harga</th>
                                        <th>Outlet</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qry_paket = mysqli_query($conn, "SELECT p.*, o.nama as nama_outlet FROM paket p JOIN outlet o ON p.id_outlet = o.id_outlet ORDER BY p.nama_paket");
                                    $no = 1;
                                    while($data_paket = mysqli_fetch_array($qry_paket)){
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data_paket['nama_paket']; ?></td>
                                        <td><?php echo ucfirst($data_paket['jenis']); ?></td>
                                        <td>Rp <?php echo number_format($data_paket['harga'], 0, ',', '.'); ?></td>
                                        <td><?php echo $data_paket['nama_outlet']; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editPaketModal<?php echo $data_paket['id_paket']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="hapus_paket.php?id_paket=<?php echo $data_paket['id_paket']; ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Apakah anda yakin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Paket Modal -->
                                    <div class="modal fade" id="editPaketModal<?php echo $data_paket['id_paket']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Paket Laundry</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="proses_ubah_paket.php" method="POST">
                                                        <input type="hidden" name="id_paket" value="<?php echo $data_paket['id_paket']; ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label">Outlet</label>
                                                            <select name="id_outlet" class="form-select" required>
                                                                <?php
                                                                $qry_outlet = mysqli_query($conn, "SELECT * FROM outlet ORDER BY nama");
                                                                while($outlet = mysqli_fetch_array($qry_outlet)){
                                                                    $selected = ($outlet['id_outlet'] == $data_paket['id_outlet']) ? 'selected' : '';
                                                                    echo "<option value='".$outlet['id_outlet']."' ".$selected.">".$outlet['nama']."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Paket</label>
                                                            <input type="text" name="nama_paket" class="form-control" 
                                                                   value="<?php echo $data_paket['nama_paket']; ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jenis</label>
                                                            <select name="jenis" class="form-select" required>
                                                                <option value="kiloan" <?php if($data_paket['jenis']=='kiloan') echo 'selected'; ?>>Kiloan</option>
                                                                <option value="selimut" <?php if($data_paket['jenis']=='selimut') echo 'selected'; ?>>Selimut</option>
                                                                <option value="bed_cover" <?php if($data_paket['jenis']=='bed_cover') echo 'selected'; ?>>Bed Cover</option>
                                                                <option value="kaos" <?php if($data_paket['jenis']=='kaos') echo 'selected'; ?>>Kaos</option>
                                                                <option value="lain" <?php if($data_paket['jenis']=='lain') echo 'selected'; ?>>Lainnya</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Harga</label>
                                                            <input type="number" name="harga" class="form-control" 
                                                                   value="<?php echo $data_paket['harga']; ?>" required>
                                                        </div>
                                                        <div class="text-end">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Paket Modal -->
    <div class="modal fade" id="addPaketModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Paket Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="proses_tambah_paket.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Outlet</label>
                            <select name="id_outlet" class="form-select" required>
                                <option value="">Pilih Outlet</option>
                                <?php
                                $qry_outlet = mysqli_query($conn, "SELECT * FROM outlet ORDER BY nama");
                                while($outlet = mysqli_fetch_array($qry_outlet)){
                                    echo "<option value='".$outlet['id_outlet']."'>".$outlet['nama']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Paket</label>
                            <input type="text" name="nama_paket" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis</label>
                            <select name="jenis" class="form-select" required>
                                <option value="">Pilih Jenis</option>
                                <option value="kiloan">Kiloan</option>
                                <option value="selimut">Selimut</option>
                                <option value="bed_cover">Bed Cover</option>
                                <option value="kaos">Kaos</option>
                                <option value="lain">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>