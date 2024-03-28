<?php
session_start();
include "db_conn.php";

// if (isset($_SESSION['user'])) {
//     $_admin_status = $_SESSION['user']['admin_access'];

//     if ($_admin_status == 1) {
//         header('location: admin.php');
//     } else {
//         header('location: admin.php');
//     }
//     exit();
// }

$_username;
$_password;
$_admin_status = 0;
$errorMsg = "";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $_username = $_POST['username'];
    $_password = $_POST['password'];
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username AND password = :pass AND status_aktif = 1");
    $stmt->bindParam(':username', $_username);
    $stmt->bindParam(':pass', $_password);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) { 
        $_SESSION['admin'] = $admin;
        header('location: admin.php');
        exit();
    } else {
        $errorMsg = "Email atau password salah. Please try again.";
        header('location: login.php?error=' . urlencode($errorMsg));
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <!-- login -->
        <section style="margin-top: 100px !important; z-index: 1">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card animate bg-white text-dark" style="border-radius: 0;">
                            <div class="card-header text-center bg-dark text-light p-3" style="border-radius: 0;">
                                <h2 class="fw-bold text-uppercase">WELCOME!</h2>
                            </div>

                            <div class="card-body p-5">
                                <?php if (!empty($errorMsg)): ?>
                                    <div class="container">
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error! </strong>
                                            <?php echo $errorMsg; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <form name="login" action="login.php" method="post" class="m-3">
                                    <div class="form-outline form-white mb-4">
                                        <h4><label class="form-label" for="typeUsernameX">Username</label></h4>
                                        <input required type="text" id="typeUsernameX" class="form-control form-control-lg"
                                            placeholder="Username" name="username" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <h4><label class="form-label" for="typePasswordX">Password</label></h4>
                                        <input required type="password" id="typePasswordX"
                                            class="form-control form-control-lg" placeholder="Password"
                                            name="password" />
                                    </div>
                                    <div class="d-grid gap-2 text-center">
                                        <button class="btn btn-dark btn-lg px-5 form-control" type="submit"
                                            name="login-btn">Login</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>  
    </div>
</body>
</html>