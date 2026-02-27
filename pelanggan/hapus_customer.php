<?php
include $_SERVER['DOCUMENT_ROOT'] . '/PENJUALAN03/koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit;
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM customer WHERE id_customer='$id'");

header("Location: dashboard.php?page=customer");
exit;
?>
