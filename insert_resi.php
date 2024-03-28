<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("INSERT INTO resi_pengiriman VALUES (NULL,:tanggal, NULL)");
    $stmt->bindParam(':tanggal', $_POST['tanggalResi']);
    
    if ($stmt->execute() && $stmt->rowCount() == 1) {
        header('location: admin.php');
        exit();
    } else {
        $errorMsg = "Entry resi gagal. Silakan coba lagi.";
    }
} else {
    echo "Metode permintaan tidak valid.";
}
?>


