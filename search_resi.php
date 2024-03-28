<?php
session_Start();
include 'db_conn.php';
if (isset($_POST['nomorResi'])) {
    $nomor_resi = $_POST['nomorResi'];
    $stmt = $pdo->prepare("SELECT * FROM log_pengiriman WHERE nomor_resi = :nomor_resi");
    $stmt->bindParam(':nomor_resi', $nomor_resi);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($stmt->rowcount()==0) {
        echo "<tr><td colspan=5 class='text-center'>No Data Found</td></tr>";
    } else {
        foreach ($rows as $row) {
            $tanggal = date('d/m/Y', strtotime($row["tanggal"]));
            $kota = $row["kota"];
            $keterangan = $row["keterangan"];
            echo "<tr>";
            echo "<td>$tanggal</td>";
            echo "<td>$kota</td>";
            echo "<td>$keterangan</td>";
            echo "</tr>";
        }
    }
}
?>