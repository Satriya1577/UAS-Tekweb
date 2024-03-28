<?php
session_start();
include 'db_conn.php';
$stmt = $pdo->query("SELECT * FROM admin");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_SESSION['admin'])) {
    $admin = $_SESSION['admin'];

    // Access user information
    $userName = $admin['username'];
} else {
    // Redirect or display an error message if the user is not logged in
    header('location: login.php'); // Redirect to the login page
    exit;
}

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['nama_admin']) && isset($_POST['statusAktif'])) {
    $stmt = $pdo->prepare("INSERT INTO admin VALUES (NULL, :username, :password, :nama_admin, :status_aktif)");
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':password', $_POST['password']);
    $stmt->bindParam(':nama_admin', $_POST['nama_admin']);
    $stmt->bindParam(':status_aktif', $_POST['statusAktif']);
    if ($stmt->execute() && $stmt->rowCount() == 1) {
        header('location: manage_admin.php');
        exit();
    } else {
        $errorMsg = "Entry admin gagal. Silakan coba lagi.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<script>
    $(document).ready(function () {
            $('.nonaktifkan-btn').on('click', function () {
                var adminId = $(this).closest('tr').find('td:first').text();
                if (confirm('Apakah Anda yakin ingin menonaktifkan admin dengan ID ' + adminId + '?')) {
                    $.ajax({
                        type: 'post',
                        url: 'update_nonaktifkan_admin.php',
                        data: { adminId : adminId },
                        success: function (response) {
                            alert('Admin dengan ID ' + adminId + ' telah dinonaktifkan.');
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error('Terjadi kesalahan: ' + error);
                        }
                    });
                }
            });

            $('.aktifkan-btn').on('click', function () {
                var adminId = $(this).closest('tr').find('td:first').text();
                if (confirm('Apakah Anda yakin ingin mengaktifkan admin dengan ID ' + adminId + '?')) {
                    $.ajax({
                        type: 'post',
                        url: 'update_aktifkan_admin.php',
                        data: { adminId : adminId },
                        success: function (response) {
                            alert('Admin dengan ID ' + adminId + ' telah diaktifkan.');
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error('Terjadi kesalahan: ' + error);
                        }
                    });
                }
            });

            // INI BUAT NAMPILIN DETAIL GAME NYA WAKTU EDIT DIKLIK
            $('.edit-admin-btn').on('click', function () {
               
                var adminID = $(this).data('admin-id');
                var username = $(this).data('username');
                var password = $(this).data('password');
                var nama = $(this).data('nama');
                $('#editNama').val(nama);
                $('#editAdminId').val(adminID);
                $('#editUsername').val(username);
                $('#editPassword').val(password);
               
                $('#editAdminModal').modal('show');
            });

            // INI BUAT NGEUPDATE DATA GAME NYA
            $('#editAdminForm').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: 'post',
                    url: 'update_admin.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#editAdminModal').modal('hide');
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error('Terjadi kesalahan: ' + error);
                    }
                });
            });
    });
    function logout() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'logout.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                window.location.href = 'index.php';
            }
        };
        xhr.send();
    }
</script>
<body>
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
        <h5 class="navbar-brand text-white" href="#">Hello ! <?php echo $userName; ?></h5>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link text-white" href="admin.php">Data Resi Pengiriman<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="manage_admin.php">User Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" onclick="logout()" href="#">Logout</a>
            </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="container-fluid border mt-3 mb-3">
            <h1><strong>Entry Data Admin</strong></h1>
            <div class="row">
                <div class="col-sm-3">
                    <form name="entryAdmin" action="manage_admin.php" method="post">
                        <label>Username</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" require>
                        </div>
                        <label>Password</label>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password">
                        </div>
                        <label>Nama Admin</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="nama_admin">
                        </div>
                        <label>Status aktif (1 = aktif, 0 = tidak aktif)</label>
                        <div class="form-group">
                            <input type="number" min=0 max=1 class="form-control" name="statusAktif">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn bg-dark text-white" value="Entry">
                        </div>
                    </form>
                </div>
                <!-- <div class="col-sm-9"></div> -->
            </div>
            <div class="row">
                <div class=" col-sm-12 table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="bg-dark text-white">Admin Id</th>
                                <th class="bg-dark text-white">Username</th>
                                <th class="bg-dark text-white">Password</th>
                                <th class="bg-dark text-white">Status Aktif</th>
                                <th class="bg-dark text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="hasil">
                            <?php
                            if ($stmt->rowcount()==0) {
                                echo "<tr><td colspan=5 class='text-center'>No Data Found</td></tr>";
                            } else {
                                foreach ($rows as $row) {
                                    $admin_id = $row["admin_id"];
                                    $username = $row["username"];
                                    $password = $row["password"];
                                    $aktif = $row["status_aktif"];
                                    $nama = $row["nama_admin"];
                                    if ($aktif == 1) {
                                        $aktif = "Aktif";
                                    } else {
                                        $aktif = "Tidak aktif";
                                    }
                                    echo "<tr>";
                                    echo "<td>$admin_id</td>";
                                    echo "<td>$username</td>";
                                    echo "<td>$password</td>";
                                    echo "<td>$aktif</td>";
                                    echo "<td><button class='edit-admin-btn btn btn-primary btn-sm' data-admin-id='$admin_id' data-nama='$nama' data-username='$username' data-password='$password' data-status='$aktif'>Edit Data Admin</button><button class='nonaktifkan-btn btn btn-danger btn-sm' style='margin-left:10px;'>Nonaktifkan Admin</button><button class='aktifkan-btn btn btn-warning btn-sm' style='margin-left:10px;'>Aktifkan Admin</button></td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Game -->
    <div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit Informasi Admin</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk mengedit informasi pengguna -->
                    <form id="editAdminForm">
                        <div class="mb-3">
                            <label for="editGambarResource" class="form-label">Username</label>
                            <input type="text" class="form-control" id="editUsername" name="editUsername"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editNominalResource" class="form-label">Password</label>
                            <input type="text" class="form-control" id="editPassword" name="editPassword"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editHarga" class="form-label">Nama Admin</label>
                            <input type="textarea" class="form-control" id="editNama" name="editNama" required>
                        </div>
                        <input type="hidden" id="editAdminId" name="editAdminId">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-4 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; UAS TEKWEB 2023 C14220311 All Rights Reserved</p>
            </div>
    </footer>
</body>
</html>