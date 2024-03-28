<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomorResi = $_POST["nomorResi"];
    if (isset($_POST["editStock"])) {
        $stock = 1;
    } else {
        $stock = 0;
    }
    $tanggal = $_POST["tanggal"];
    $kota = $_POST["kota"];
    $keterangan = $_POST["keterangan"];

   
    $stmt = $pdo->prepare("INSERT INTO log_pengiriman VALUES (:tanggal, :kota, :keterangan, :nomor_resi, NULL)");
    $stmt->bindParam(':tanggal', $tanggal);
    $stmt->bindParam(':kota', $kota);
    $stmt->bindParam(':keterangan', $keterangan);
    $stmt->bindParam(':nomor_resi', $nomorResi);
    
    try {
        if ($stmt->execute() && $stmt->rowCount() == 1) {
            header('location: admin.php');
            exit();
        } else {
            $errorMsg = "Registrasi gagal. Silakan coba lagi.";
        }
    } catch (PDOException $e) {
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
} else {
    echo "Metode permintaan tidak valid.";
}
?>


