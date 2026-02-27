<?php
include $_SERVER['DOCUMENT_ROOT'] . '/PENJUALAN03/koneksi.php';

// Ambil data customer
$customer = mysqli_query($conn, "SELECT * FROM customer");

if (isset($_POST['simpan'])) {
    $tanggal     = $_POST['tanggal'];
    $id_customer = $_POST['id_customer'];

    mysqli_query($conn, "
        INSERT INTO transaksi (tanggal, id_customer, total)
        VALUES ('$tanggal', '$id_customer', 0)
    ");

    header("Location: dashboard.php?page=transaksi");
    exit;
}
?>

<style>
.card {
    background: #ffffff;
    padding: 30px;
    border-radius: 10px;
    max-width: 720px;
    margin-right: auto;
    margin-left: 0;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
}

.card h3 {
    margin-bottom: 20px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 6px;
}

input, select {
    width: 100%;
    background-color: white;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

input:focus, select:focus {
    outline: none;
    border-color: #3498db;
}

.btn {
    padding: 10px 16px;
    border-radius: 5px;
    text-decoration: none;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 14px;
}

.btn-tambah {
    background: #27ae60;
}

.btn-hapus {
    background: #c0392b;
}
</style>

<div class="card">
    <h3>Transaksi Baru</h3>
    <form method="post">

        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" value="<?= date('Y-m-d'); ?>" required>
        </div>

        <div class="form-group">
            <label>Customer</label>
            <select name="id_customer" required>
                <option value="">-- Pilih Customer --</option>
                <?php while ($c = mysqli_fetch_assoc($customer)) { ?>
                    <option value="<?= $c['id_customer']; ?>">
                        <?= $c['nama_customer']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" name="simpan" class="btn btn-tambah">Simpan</button>
        <a href="dashboard.php?page=transaksi" class="btn btn-hapus">Batal</a>

    </form>
</div>
