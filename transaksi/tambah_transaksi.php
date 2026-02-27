<?php
include $_SERVER['DOCUMENT_ROOT'] . '/PENJUALAN03/koneksi.php';

// Ambil data customer & produk
$customer = mysqli_query($conn, "SELECT * FROM customer");
$produk   = mysqli_query($conn, "SELECT * FROM barang");

if (isset($_POST['simpan'])) {
    $tanggal     = $_POST['tanggal'];
    $id_customer = $_POST['id_customer'];
    
    // Simpan transaksi utama
    mysqli_query($conn, "
        INSERT INTO transaksi (tanggal, id_customer, total)
        VALUES ('$tanggal', '$id_customer', 0)
    ");
    $id_transaksi = mysqli_insert_id($conn);

    // Simpan detail transaksi
    $total = 0;
    foreach ($_POST['produk'] as $key => $id_barang) {
        $qty   = $_POST['qty'][$key];
        $harga = $_POST['harga'][$key];
        $subtotal = $qty * $harga;
        $total += $subtotal;

        mysqli_query($conn, "
            INSERT INTO transaksi_detail (id_transaksi, id_barang, qty, harga, subtotal)
            VALUES ($id_transaksi, $id_barang, $qty, $harga, $subtotal)
        ");
    }

    // Update total transaksi
    mysqli_query($conn, "UPDATE transaksi SET total = $total WHERE id_transaksi = $id_transaksi");

    header("Location: dashboard.php?page=transaksi");
    exit;
}
?>

<style>
.card {
    background: #ffffff;
    padding: 30px;
    border-radius: 10px;
    max-width: 900px;
    margin: 20px auto;
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
    margin-top: 10px;
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
                    <option value="<?= $c['id_customer']; ?>"><?= $c['nama_customer']; ?></option>
                <?php } ?>
            </select>
        </div>

        <h4>Produk</h4>
        <div id="produk-container">
            <div class="form-group">
                <label>Produk</label>
                <select name="produk[]" required>
                    <option value="">-- Pilih Produk --</option>
                    <?php while ($p = mysqli_fetch_assoc($produk)) { ?>
                        <option value="<?= $p['id_barang']; ?>" data-harga="<?= $p['harga']; ?>">
                            <?= $p['nama_barang']; ?> (Rp <?= number_format($p['harga']); ?>)
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Qty</label>
                <input type="number" name="qty[]" value="1" min="1" required>
            </div>
            <input type="hidden" name="harga[]" value="">
        </div>

        <button type="button" onclick="tambahProduk()" class="btn btn-tambah">Tambah Produk</button>
        <br>
        <button type="submit" name="simpan" class="btn btn-tambah">Simpan Transaksi</button>
        <a href="dashboard.php?page=transaksi" class="btn btn-hapus">Batal</a>

    </form>
</div>

<script>
// Otomatis isi harga saat produk dipilih
document.addEventListener('change', function(e) {
    if(e.target.name == 'produk[]') {
        var hargaInput = e.target.parentElement.parentElement.querySelector('input[name="harga[]"]');
        hargaInput.value = e.target.selectedOptions[0].dataset.harga || 0;
    }
});

function tambahProduk() {
    var container = document.getElementById('produk-container');
    var newGroup = container.children[0].cloneNode(true);
    // Reset value
    newGroup.querySelector('select').value = '';
    newGroup.querySelector('input[type="number"]').value = 1;
    newGroup.querySelector('input[name="harga[]"]').value = '';
    container.appendChild(newGroup);
}
</script>