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

$(document).ready(function() {
    $("#cariResiForm").submit(function(e) {
        e.preventDefault();
    //$("#b1").on("click", function(e) {
    //    e.preventDefault();
        $.ajax({
            type: "post",
            url: "search_resi.php",
            data: $(this).serialize(),
            //data: { username: $("#username").val(),
            //        passw: $("#passw").val()
            //},
            success: function(response) {
                //$.each(response, function(index, object) {
                //    console.log(index);
                //    console.log(object.username);
                //    console.log(object.passw);
                //});
                $("#hasil").html(response);
            }
        });
    });
});
</script>

<body>
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
        <h5 class="navbar-brand text-white">WELCOME !</h5>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link text-white" href="login.php">Login Admin <span class="sr-only">(current)</span></a>
                </li>
                </ul>
            </div>
    </nav>  
    <div class="container-fluid">
        <div class="container-fluid border mt-3 mb-3">
            <h1 class= "mt-3"><strong>Cek Pengiriman</strong></h1>
            <div class="row">
                <div class="col-sm-12">
                    <form id="cariResiForm" class="row g-3">
                        <div class="col-auto">
                            <input type="text" id="nomorResi" name="nomorResi" placeholder="Nomor Pengiriman" require>
                        </div>
                        <button type="submit" class="btn btn-sm bg-dark text-white mb-3">Lihat</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class=" col-sm-12 table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="bg-dark text-white">Tanggal</th>
                                    <th class="bg-dark text-white">Kota</th>
                                    <th class="bg-dark text-white">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="hasil">
                            <tr><td colspan=5 class='text-center'>No Data Found</td></tr>
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