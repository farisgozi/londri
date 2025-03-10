<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Outlet | Launnres</title>
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
                    <h5 class="mb-0">Launnres</h5>
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
                            <a href="paket.php" class="nav-link text-white">
                                <i class="fas fa-box me-2"></i> Paket Laundry
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="outlet.php" class="nav-link text-white active">
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
                    <span class="navbar-brand mb-0 h1">Outlet</span>
                </div>
            </nav>

            <!-- Content -->
            <div class="container-fluid p-4">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Outlet</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOutletModal">
                            <i class="fas fa-plus me-2"></i>Tambah Outlet
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Outlet</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "koneksi.php";
                                    $qry_outlet = mysqli_query($conn, "SELECT * FROM outlet ORDER BY nama");
                                    $no = 1;
                                    while($data_outlet = mysqli_fetch_array($qry_outlet)){
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data_outlet['nama']; ?></td>
                                        <td><?php echo $data_outlet['alamat']; ?></td>
                                        <td><?php echo $data_outlet['tlp']; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info editOutletBtn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editOutletModal"
                                                        data-id="<?php echo $data_outlet['id_outlet']; ?>"
                                                        data-nama="<?php echo $data_outlet['nama']; ?>"
                                                        data-alamat="<?php echo $data_outlet['alamat']; ?>"
                                                        data-tlp="<?php echo $data_outlet['tlp']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="hapus_outlet.php?id_outlet=<?php echo $data_outlet['id_outlet']; ?>" 
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

    <!-- Add Outlet Modal -->
    <div class="modal fade" id="addOutletModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Outlet Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="proses_tambah_outlet.php" method="POST" onsubmit="return validateOutletForm(this);">
                        <div class="mb-3">
                            <label class="form-label">Nama Outlet</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="tlp" class="form-control" required>
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

    <!-- Edit Outlet Modal -->
    <div class="modal fade" id="editOutletModal" tabindex="-1" aria-labelledby="editOutletModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOutletModalLabel">Edit Data Outlet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="editOutletForm" action="proses_ubah_outlet.php" method="POST">
                        <input type="hidden" name="id_outlet" id="id_outlet_edit">
                        <div class="mb-3">
                            <label class="form-label">Nama Outlet</label>
                            <input type="text" name="nama" id="nama_edit" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat_edit" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="tlp" id="tlp_edit" class="form-control" required>
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
    <script>
        function validateOutletForm(form) {
            var outletName = form.nama.value;
            var phoneNumber = form.tlp.value;

            // Validate Outlet Name
            var xhrName = new XMLHttpRequest();
            xhrName.open('GET', 'get_existing_outlet_names.php', true);
            xhrName.onload = function () {
                if (xhrName.status >= 200 && xhrName.status < 300) {
                    var existingOutletNames = JSON.parse(xhrName.responseText);
                    if (existingOutletNames.includes(outletName)) {
                        alert('Nama outlet sudah terdaftar.');
                        form.nama.focus();
                        return false; // Prevent form submission
                    } else {
                        // Validate Phone Number
                        var xhrPhone = new XMLHttpRequest();
                        xhrPhone.open('GET', 'get_existing_outlet_phone_numbers.php', true);
                        xhrPhone.onload = function () {
                            if (xhrPhone.status >= 200 && xhrPhone.status < 300) {
                                var existingPhoneNumbers = JSON.parse(xhrPhone.responseText);
                                if (existingPhoneNumbers.includes(phoneNumber)) {
                                    alert('Nomor telepon sudah terdaftar.');
                                    form.tlp.focus();
                                    return false; // Prevent form submission
                                } else {
                                    form.submit(); // Allow form submission
                                }
                            } else {
                                alert('Gagal mengambil data nomor telepon.');
                                return false;
                            }
                        };
                        xhrPhone.onerror = function () {
                            alert('Gagal mengambil data nomor telepon.');
                            return false;
                        };
                        xhrPhone.send();
                        return false; // Prevent default form submission while AJAX is in progress
                    }
                } else {
                    alert('Gagal mengambil data nama outlet.');
                    return false;
                }
            };
            xhrName.onerror = function () {
                alert('Gagal mengambil data nama outlet.');
                return false;
            };
            xhrName.send();
            return false; // Prevent default form submission while AJAX is in progress
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Edit Outlet Functionality
            const editOutletButtons = document.querySelectorAll('.editOutletBtn');
            editOutletButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama;
                    const alamat = this.dataset.alamat;
                    const tlp = this.dataset.tlp;

                    document.getElementById('id_outlet_edit').value = id;
                    document.getElementById('nama_edit').value = nama;
                    document.getElementById('alamat_edit').value = alamat;
                    document.getElementById('tlp_edit').value = tlp;
                });
            });

            // Edit Outlet Form Submission
            const editOutletForm = document.querySelector('.editOutletForm');
            editOutletForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch('proses_ubah_outlet.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Show response from server
                    window.location.reload(); // Reload the page to update the table
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengubah data outlet.');
                });
            });
        });
    </script>
</body>
</html>