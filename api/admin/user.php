<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User | Launnres</title>
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
                            <a href="outlet.php" class="nav-link text-white">
                                <i class="fas fa-store me-2"></i> Outlet
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="user.php" class="nav-link text-white active">
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
                    <span class="navbar-brand mb-0 h1">User</span>
                </div>
            </nav>

            <!-- Content -->
            <div class="container-fluid p-4">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar User</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="fas fa-plus me-2"></i>Tambah User
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama User</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Outlet</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "koneksi.php";
                                    $qry_user = mysqli_query($conn, "SELECT u.*, o.nama as nama_outlet FROM user u JOIN outlet o ON u.id_outlet = o.id_outlet ORDER BY u.nama_user");
                                    $no = 1;
                                    while($data_user = mysqli_fetch_array($qry_user)){
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $data_user['nama_user']; ?></td>
                                        <td><?php echo $data_user['username']; ?></td>
                                        <td><?php echo ucfirst($data_user['role']); ?></td>
                                        <td><?php echo $data_user['nama_outlet']; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info editUserBtn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal"
                                                        data-id="<?php echo $data_user['id_user']; ?>"
                                                        data-nama_user="<?php echo $data_user['nama_user']; ?>"
                                                        data-username="<?php echo $data_user['username']; ?>"
                                                        data-id_outlet="<?php echo $data_user['id_outlet']; ?>"
                                                        data-role="<?php echo $data_user['role']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="hapus_user.php?id_user=<?php echo $data_user['id_user']; ?>" 
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

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="proses_tambah_user.php" method="POST" onsubmit="return validateUserForm(this);">
                        <div class="mb-3">
                            <label class="form-label">Nama User</label>
                            <input type="text" name="nama_user" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
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
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="kasir">Kasir</option>
                                <option value="owner">Owner</option>
                            </select>
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

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="editUserForm" action="proses_ubah_user.php" method="POST">
                        <input type="hidden" name="id_user" id="id_user_edit">
                        <div class="mb-3">
                            <label class="form-label">Nama User</label>
                            <input type="text" name="nama_user" id="nama_user_edit" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" id="username_edit" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" id="password_edit" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Outlet</label>
                            <select name="id_outlet" id="id_outlet_edit" class="form-select" required>
                                <?php
                                $qry_outlet = mysqli_query($conn, "SELECT * FROM outlet ORDER BY nama");
                                while($outlet = mysqli_fetch_array($qry_outlet)){
                                    echo "<option value='".$outlet['id_outlet']."'>".$outlet['nama']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" id="role_edit" class="form-select" required>
                                <option value="admin">Admin</option>
                                <option value="kasir">Kasir</option>
                                <option value="owner">Owner</option>
                            </select>
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
        function validateUserForm(form) {
            var username = form.username.value;

            // Validate Username
            var xhrUsername = new XMLHttpRequest();
            xhrUsername.open('GET', 'get_existing_usernames.php', true);
            xhrUsername.onload = function () {
                if (xhrUsername.status >= 200 && xhrUsername.status < 300) {
                    var existingUsernames = JSON.parse(xhrUsername.responseText);
                    if (existingUsernames.includes(username)) {
                        alert('Username sudah terdaftar.');
                        form.username.focus();
                        return false; // Prevent form submission
                    } else {
                        form.submit(); // Allow form submission
                    }
                } else {
                    alert('Gagal mengambil data username.');
                    return false;
                }
            };
            xhrUsername.onerror = function () {
                alert('Gagal mengambil data username.');
                return false;
            };
            xhrUsername.send();
            return false; // Prevent default form submission while AJAX is in progress
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Edit User Functionality
            const editUserButtons = document.querySelectorAll('.editUserBtn');
            editUserButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nama_user = this.dataset.nama_user;
                    const username = this.dataset.username;
                    const id_outlet = this.dataset.id_outlet;
                    const role = this.dataset.role;

                    document.getElementById('id_user_edit').value = id;
                    document.getElementById('nama_user_edit').value = nama_user;
                    document.getElementById('username_edit').value = username;
                    document.getElementById('id_outlet_edit').value = id_outlet;
                    document.getElementById('role_edit').value = role;
                });
            });

            // Edit User Form Submission
            const editUserForm = document.querySelector('.editUserForm');
            editUserForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch('proses_ubah_user.php', {
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
                    alert('Terjadi kesalahan saat mengubah data user.');
                });
            });
        });
    </script>
</body>
</html>