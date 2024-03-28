<?php
session_start();
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];

    $stmt = $pdo->prepare("DELETE FROM log_pengiriman WHERE nomor_resi = ?");
    $stmt->execute([$itemId]);
    $stmt = $pdo->prepare("DELETE FROM resi_pengiriman WHERE nomor_resi = ?");
    $stmt->execute([$itemId]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'User not found or deletion failed.'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Invalid request.'));
}
?>