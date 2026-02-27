<?php
include $_SERVER['DOCUMENT_ROOT'] . '/PENJUALAN03/koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID transaksi tidak ditemukan!";
    exit;
}

$id = $_GET['id'];

// Hapus detail transaksi dulu (biar tidak error relasi)
mysqli_query($conn, "DELETE FROM transaksi_detail WHERE id_transaksi='$id'");

// Hapus transaksi utama
mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi='$id'");

header("Location: dashboard.php?page=transaksi");
exit;
?>
