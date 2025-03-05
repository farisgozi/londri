<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pelanggan | Launnres</title>
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
                            <a href="member.php" class="nav-link text-white active">
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
                    <span class="navbar-brand mb-0 h1">Data Pelanggan</span>
                </div>
            </nav>

            <!-- Content -->
            <div class="container-fluid p-4">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Pelanggan</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                            <i class="fas fa-plus me-2"></i>Tambah Pelanggan
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Telepon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "koneksi.php";
                                    $qry_member = mysqli_query($conn, "SELECT * FROM member ORDER BY nama_member");
                                    $no = 1;
                                    while($data_member = mysqli_fetch_array($qry_member)){
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data_member['nama_member']; ?></td>
                                        <td><?php echo $data_member['alamat']; ?></td>
                                        <td><?php echo $data_member['jenis_kelamin']; ?></td>
                                        <td><?php echo $data_member['tlp']; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info editMemberBtn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editMemberModal"
                                                        data-id="<?php echo $data_member['id_member']; ?>"
                                                        data-nama="<?php echo $data_member['nama_member']; ?>"
                                                        data-alamat="<?php echo $data_member['alamat']; ?>"
                                                        data-jenis_kelamin="<?php echo $data_member['jenis_kelamin']; ?>"
                                                        data-tlp="<?php echo $data_member['tlp']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="hapus_member.php?id_member=<?php echo $data_member['id_member']; ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Apakah anda yakin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Member Modal -->
                                    
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Member Modal -->
    <div class="modal" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberModalLabel">Tambah Pelanggan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="proses_tambah_member.php" method="POST" id="addMemberForm">
                        <div class="mb-3">
                            <label for="nama_member_new" class="form-label">Nama Pelanggan</label>
                            <input type="text" name="nama_member" id="nama_member_new" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_new" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat_new" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin_new" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin_new" class="form-select" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tlp_new" class="form-label">Telepon</label>
                            <input type="text" name="tlp" id="tlp_new" class="form-control" required>
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

        <!-- Edit Member Modal -->
        <div class="modal" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMemberModalLabel">Edit Data Pelanggan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="editMemberForm" action="proses_ubah_member.php" method="POST">
                            <input type="hidden" name="id_member" id="id_member_edit">
                            <div class="mb-3">
                                <label for="nama_member_edit" class="form-label">Nama Pelanggan</label>
                                <input type="text" name="nama_member" id="nama_member_edit" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat_edit" class="form-label">Alamat</label>
                                <textarea name="alamat" id="alamat_edit" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin_edit" class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin_edit" class="form-select" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tlp_edit" class="form-label">Telepon</label>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Fix for modal issues
            var addMemberForm = document.getElementById('addMemberForm');
            if (addMemberForm) {
                addMemberForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    validatePhoneNumber(this);
                });
            }

            // Ensure proper modal behavior
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                modal._modalBackdrop = null;
            });

            // Edit Member Functionality
            const editMemberButtons = document.querySelectorAll('.editMemberBtn');
            editMemberButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama;
                    const alamat = this.dataset.alamat;
                    const jenis_kelamin = this.dataset.jenis_kelamin;
                    const tlp = this.dataset.tlp;

                    document.getElementById('id_member_edit').value = id;
                    document.getElementById('nama_member_edit').value = nama;
                    document.getElementById('alamat_edit').value = alamat;
                    document.getElementById('jenis_kelamin_edit').value = jenis_kelamin;
                    document.getElementById('tlp_edit').value = tlp;
                });
            });

            // Edit Member Form Submission
            const editMemberForm = document.querySelector('.editMemberForm');
            editMemberForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch('proses_ubah_member.php', {
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
                    alert('Terjadi kesalahan saat mengubah data member.');
                });
            });
        });

        function validatePhoneNumber(form) {
            var phoneNumber = form.tlp.value;
            var memberName = form.nama_member.value;

            // Validate Member Name
            var xhrName = new XMLHttpRequest();
            xhrName.open('GET', 'get_existing_member_names.php', true);
            xhrName.onload = function () {
                if (xhrName.status >= 200 && xhrName.status < 300) {
                    var existingMemberNames = JSON.parse(xhrName.responseText);
                    if (existingMemberNames.includes(memberName)) {
                        alert('Nama member sudah terdaftar.');
                        form.nama_member.focus();
                    } else {
                        // Validate Phone Number
                        var xhrPhone = new XMLHttpRequest();
                        xhrPhone.open('GET', 'get_existing_phone_numbers.php', true);
                        xhrPhone.onload = function () {
                            if (xhrPhone.status >= 200 && xhrPhone.status < 300) {
                                var existingPhoneNumbers = JSON.parse(xhrPhone.responseText);
                                if (existingPhoneNumbers.includes(phoneNumber)) {
                                    alert('Nomor telepon sudah terdaftar.');
                                    form.tlp.focus();
                                } else {
                                    form.submit(); // Allow form submission
                                }
                            } else {
                                alert('Gagal mengambil data nomor telepon.');
                            }
                        };
                        xhrPhone.onerror = function () {
                            alert('Gagal mengambil data nomor telepon.');
                        };
                        xhrPhone.send();
                    }
                } else {
                    alert('Gagal mengambil data nama member.');
                }
            };
            xhrName.onerror = function () {
                alert('Gagal mengambil data nama member.');
            };
            xhrName.send();
        }
    </script>
</body>
</html>