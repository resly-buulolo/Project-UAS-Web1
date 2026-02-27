<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// koneksi
include $_SERVER['DOCUMENT_ROOT'] . '/PENJUALAN03/koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit;
}

$id = $_GET['id'];

// ambil data customer
$query = mysqli_query($conn, "SELECT * FROM customer WHERE id_customer='$id'");
$data  = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data customer tidak ditemukan!";
    exit;
}

// proses update
if (isset($_POST['update'])) {
    mysqli_query($conn, "UPDATE customer SET
        nama_customer = '$_POST[nama_customer]',
        email         = '$_POST[email]',
        alamat        = '$_POST[alamat]',
        no_hp         = '$_POST[no_hp]'
        WHERE id_customer = '$id'
    ");

    header("Location: dashboard.php?page=customer");
    exit;
}
?>

<style>
.card {
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    max-width: 600px;
    box-shadow: 0 3px 10px rgba(0,0,0,.1);
}
.form-group {
    margin-bottom: 12px;
}
label {
    font-weight: bold;
}
input, textarea {
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
    <h3>Edit Customer</h3>
    <form method="post">

        <div class="form-group">
            <label>Nama Customer</label>
            <input type="text" name="nama_customer" value="<?= $data['nama_customer']; ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= $data['email']; ?>" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" required><?= $data['alamat']; ?></textarea>
        </div>

        <div class="form-group">
            <label>No HP</label>
            <input type="text" name="no_hp" value="<?= $data['no_hp']; ?>" required>
        </div>

        <button type="submit" name="update" class="btn-edit">Update</button>
        <a href="dashboard.php?page=customer" class="btn-hapus">Batal</a>

    </form>
</div>
