<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// PATH PALING AMAN
include $_SERVER['DOCUMENT_ROOT'] . '/PENJUALAN03/koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit;
}

$id = $_GET['id'];

// AMBIL DATA DARI DATABASE
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id'");
$data  = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan di database!";
    exit;
}

// PROSES UPDATE
if (isset($_POST['update'])) {
    mysqli_query($conn, "UPDATE barang SET
        kode_barang = '$_POST[kode_barang]',
        nama_barang = '$_POST[nama_barang]',
        kategori    = '$_POST[kategori]',
        harga       = '$_POST[harga]',
        stok        = '$_POST[stok]',
        satuan      = '$_POST[satuan]'
        WHERE id_barang = '$id'
    ");

    header("Location: dashboard.php?page=listproducts");
    exit;
}
?>

<style>
.card {
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    max-width: 700px;
    box-shadow: 0 3px 10px rgba(0,0,0,.1);
}
.form-group {
    margin-bottom: 12px;
}
label {
    font-weight: bold;
}
input {
    width: 100%;
    padding: 10px;
}
.btn-edit {
    background: #2980b9;
    color: #fff;
    padding: 8px 14px;
    border: none;
    border-radius: 5px;
}
.btn-hapus {
    background: #c0392b;
    color: #fff;
    padding: 8px 14px;
    border-radius: 5px;
    text-decoration: none;
}
</style>

<div class="card">
    <h3>Edit Produk</h3>
    <form method="post">
        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" value="<?= $data['kode_barang']; ?>" required>
        </div>

        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" value="<?= $data['nama_barang']; ?>" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <input type="text" name="kategori" value="<?= $data['kategori']; ?>">
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" value="<?= $data['harga']; ?>" required>
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" value="<?= $data['stok']; ?>" required>
        </div>

        <div class="form-group">
            <label>Satuan</label>
            <input type="text" name="satuan" value="<?= $data['satuan']; ?>">
        </div>

        <button type="submit" name="update" class="btn-edit">Update</button>
        <a href="dashboard.php?page=listproducts" class="btn-hapus">Batal</a>
    </form>
</div>
