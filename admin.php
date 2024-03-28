<?php
session_start();
include 'db_conn.php';
$stmt = $pdo->query("SELECT * FROM resi_pengiriman");
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
            var itemId = $(this).closest('tr').find('td:nth-child(2)').text().trim();
                if (confirm('Apakah Anda yakin ingin menghapus nomor resi ' + itemId + '?')) {
                    $.ajax({
                        type: 'post',
                        url: 'delete_resi.php',
                        data: { itemId: itemId },
                        success: function (response) {
                            alert('Nomor Resi ' + itemId + ' Telah Dihapus.');
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error('Terjadi kesalahan: ' + error);
                        }
                    });
                }
        });
        

        $('.entry-log-btn').on('click', function () {
            var nomorResi = $(this).data('nomor-resi');
            $('#nomorResi').val(nomorResi);
            document.getElementById('labelNomorResi').innerHTML = "Entry Log Untuk Nomor Resi : " + nomorResi;
            $('#entryLogModal').modal('show');
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
    <div class="container-fluid m-0">
        

        <div class="container-fluid border mt-3 mb-3 pt-3 pb-3">
            <h1 class="mt-3"><strong>Entry Nomor Resi</strong></h1>
            <div class="row">
                <div class="col-sm-3">
                    <form id="entryNomorResi">
                        <label>Tanggal</label>
                        <div class="form-group">
                            <input type="date" class="form-control" name="tanggalResi" require>
                        </div>
                        <label>Nomor Resi</label>
                        <div class="form-group">
                            <input type="number" class="form-control" name="nomorResi" placeholder="tidak usah diisi, sudah auto increment">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn form-control bg-dark text-white" value="Entry">
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
                                <th class="bg-dark text-white">Tanggal Resi</th>
                                <th class="bg-dark text-white">Nomor Resi</th>
                                <th class="bg-dark text-white">Action</th>
                            </tr>
                        </thead>
                        <tbody id="hasil">
                        <!-- <button class="btn btn-dark btn-sm"  
                                style="margin-left: 10px;"><i class="fa-solid fa-plus"
                                    style="padding:0 8px 0 0px"></i><strong>Tambah Item</strong></button> -->
                            <?php
                            if ($stmt->rowcount() == 0) {
                                echo "<tr><td colspan=5 class='text-center'>No Data Found</td></tr>";
                            } else {
                                foreach ($rows as $row) {
                                    $tanggal_resi = date('d/m/Y', strtotime($row["tanggal_resi"]));
                                    $nomor_resi = $row["nomor_resi"];
                                    echo "<tr>";
                                    echo "<td>$tanggal_resi</td>";
                                    echo "<td>$nomor_resi</td>";
                                    echo "<td><a href='list_entry_log.php?nomorResi=$nomor_resi'><button class='entry-log-btn btn btn-primary btn-sm'>Entry Log</button>";
                                    echo "<button class='del-btn btn btn-danger btn-sm' data-nomor-resi='$nomor_resi' style='margin-left:10px;'>Delete</button></td>";
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