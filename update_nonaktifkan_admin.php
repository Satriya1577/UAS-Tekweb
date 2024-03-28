<?php
session_start();
include 'db_conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminId = $_POST["adminId"];
    $stmt = $pdo->prepare("UPDATE admin SET status_aktif = 0 WHERE admin_id = ?");
    try {
        if ($stmt->execute([$adminId])) {
            echo "Data admin berhasil diperbarui.";
        } else {
            echo "Terjadi kesalahan saat memperbarui data pengguna.";
        }
    } catch (PDOException $e) {
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
} else {
    echo "Metode permintaan tidak valid.";
}
?>
