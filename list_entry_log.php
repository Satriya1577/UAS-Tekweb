<?php 
    session_start();
    include 'db_conn.php';
    $nomorResi = $_GET['nomorResi'];
    if (!isset($_GET['nomorResi'])) {
        header('location: admin.php');
        exit;
    }

    if (isset($_SESSION['admin'])) {
        $admin = $_SESSION['admin'];
    
        // Access user information
        $userName = $admin['username'];
    } else {
        // Redirect or display an error message if the user is not logged in
        header('location: login.php'); // Redirect to the login page
        exit;
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
    <script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>
<script>
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


    $(document).ready(function () {
        $('.del-btn').on('click', function () {
            var nomorResi = $(this).closest('tr').find('td:first').text();
            $('#nomorResi').val(nomorResi);
            //var itemId = $(this).closest('tr').find('td:nth-child(2)').text().trim();
                if (confirm('Apakah Anda yakin ingin menghapus log dari nomor resi ' + nomorResi + '?')) {
                    $.ajax({
                        type: 'post',
                        url: 'delete_log_pengiriman.php',
                        data: { nomorResi: nomorResi },
                        success: function (response) {
                            alert('Nomor Resi ' + nomorResi + ' Telah Dihapus.');
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error('Terjadi kesalahan: ' + error);
                        }
                    });
                }
        });
        
        $('#addEntryLogForm').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: 'post',
                    url: 'insert_entry.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#entryLogModal').modal('hide');
                        alert('Data berhasil ditambahkan.');
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error('Terjadi kesalahan: ' + error);
                    }
                });
        });

        $('#entryNomorResi').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: 'post',
                    url: 'insert_resi.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        // $('#entryLogModal').modal('hide');
                        // alert('Data berhasil ditambahkan.');
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error('Terjadi kesalahan: ' + error);
                    }
                });
        });

        $('#addEntryLogForm').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    type: 'post',
                    url: 'insert_log_pengiriman.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#entryLogModal').modal('hide');
                        alert('Data berhasil ditambahkan.');
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error('Terjadi kesalahan: ' + error);
                    }
                });
        });
    });

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
        <div class="container-fluid border mt-3 mb-3 pt-3 pb-3">
            <h1 class="mt-3"><strong>List Entry Log Untuk Nomor Resi <?php echo $nomorResi; ?></strong></h1>
            <div class="row">
                <div class="col-sm-3">
                    <form id="addEntryLogForm">
                            <div class="mb-3">
                                <label for="editStock" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="mb-3">
                                <label for="editGambarResource" class="form-label">Kota</label>
                                <input type="text" class="form-control" id="kota" name="kota"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editNominalResource" class="form-label">Keterangan</label>
                                <input type="textfield" class="form-control" id="keterangan" name="keterangan"
                                    required>
                            </div>
                            <?php echo "<input type='hidden' name='nomorResi' id='nomorResi' value = " . $nomorResi . ">" ?>
                            <!-- <input type="hidden" name="nomorResi" id="nomorResi">  -->
                            <div class="form-group">
                                <input type="submit" class="btn form-control bg-dark text-white" value="Entry Log Pengiriman">
                            </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class=" col-sm-12 table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="bg-dark text-white">ID</th>
                                <th class="bg-dark text-white">Tanggal</th>
                                <th class="bg-dark text-white">Kota</th>
                                <th class="bg-dark text-white">Keterangan</th>
                                <th class="bg-dark text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody id="hasil">
                        
                            <?php
                                $stmt = $pdo->prepare("SELECT * FROM log_pengiriman WHERE nomor_resi = :nomor_resi");
                                $stmt->bindParam(":nomor_resi", $nomorResi);
                                $stmt->execute();
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                if ($stmt->rowcount() == 0) {
                                    echo "<tr><td colspan=5 class='text-center'>No Data Found</td></tr>";
                                } else {
                                    foreach ($rows as $row) {
                                        $tanggal_resi = $row["tanggal"];
                                        $kota = $row["kota"];
                                        $keterangan = $row["keterangan"];
                                        $nomor_resi = $row["nomor_resi"];
                                        $log_id = $row["log_id"];
                                        echo "<tr>";
                                        echo "<td>$log_id</td>";
                                        echo "<td>$tanggal_resi</td>";
                                        echo "<td>$kota</td>";
                                        echo "<td>$keterangan</td>";
                                        echo "<td><button class='del-btn btn btn-danger btn-sm' data-nomor-resi='$nomor_resi' style='margin-left:10px;'>Delete</button></td>";
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
    <footer class="py-4 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; UAS TEKWEB 2023 C14220311 All Rights Reserved</p>
            </div>
    </footer>
</body>
</html>