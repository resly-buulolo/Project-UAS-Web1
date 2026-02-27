<?php
include $_SERVER['DOCUMENT_ROOT'] . '/PENJUALAN03/koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit;
}

$id = $_GET['id'];

// Ambil data transaksi
$trx = mysqli_query($conn, "
    SELECT t.*, c.nama_customer
    FROM transaksi t
    LEFT JOIN customer c ON t.id_customer = c.id_customer
    WHERE t.id_transaksi = '$id'
");

$transaksi = mysqli_fetch_assoc($trx);

if (!$transaksi) {
    echo "Data tidak ditemukan!";
    exit;
}

// Ambil detail transaksi
$detail = mysqli_query($conn, "
    SELECT td.*, b.nama_barang
    FROM transaksi_detail td
    JOIN barang b ON td.id_barang = b.id_barang
    WHERE td.id_transaksi = '$id'
");

// Ambil semua customer
$customer = mysqli_query($conn, "SELECT * FROM customer");

// Ambil semua barang
$barang = mysqli_query($conn, "SELECT * FROM barang");


// UPDATE CUSTOMER
if (isset($_POST['update_customer'])) {

    $id_customer = $_POST['id_customer'];

    mysqli_query($conn, "
        UPDATE transaksi
        SET id_customer = '$id_customer'
        WHERE id_transaksi = '$id'
    ");

    header("Location: dashboard.php?page=edit_transaksi&id=$id");
    exit;
}


// TAMBAH PRODUK
if (isset($_POST['tambah_produk'])) {

    $id_barang = $_POST['id_barang'];
    $qty       = $_POST['qty'];

    $b = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT * FROM barang WHERE id_barang='$id_barang'"
    ));

    $harga = $b['harga'];
    $subtotal = $qty * $harga;

    mysqli_query($conn, "
        INSERT INTO transaksi_detail
        (id_transaksi, id_barang, qty, harga, subtotal)
        VALUES
        ('$id', '$id_barang', '$qty', '$harga', '$subtotal')
    ");

    // Update total
    mysqli_query($conn, "
        UPDATE transaksi SET total = (
            SELECT SUM(subtotal)
            FROM transaksi_detail
            WHERE id_transaksi='$id'
        )
        WHERE id_transaksi='$id'
    ");

    header("Location: dashboard.php?page=edit_transaksi&id=$id");
    exit;
}
?>

<style>
.card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,.1);
    margin-bottom: 20px;
}

.btn {
    padding: 6px 12px;
    border-radius: 4px;
    color: white;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.btn-update { background: #2980b9; }
.btn-tambah { background: #27ae60; }
.btn-hapus  { background: #c0392b; }

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}
</style>

<div class="card">
<h3>Edit Transaksi</h3>

<form method="post">
    <label>Customer:</label>
    <select name="id_customer" required>
        <?php while($c = mysqli_fetch_assoc($customer)) { ?>
            <option value="<?= $c['id_customer']; ?>"
                <?= $c['id_customer'] == $transaksi['id_customer'] ? 'selected' : ''; ?>>
                <?= $c['nama_customer']; ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit" name="update_customer" class="btn btn-update">
        Update Customer
    </button>
</form>

<p>
Tanggal: <b><?= $transaksi['tanggal']; ?></b> |
Total: <b>Rp <?= number_format($transaksi['total'],0,',','.'); ?></b>
</p>
</div>


<div class="card">
<h4>Tambah Produk</h4>

<form method="post">
    <select name="id_barang" required>
        <option value="">-- Pilih Produk --</option>
        <?php while($b = mysqli_fetch_assoc($barang)) { ?>
            <option value="<?= $b['id_barang']; ?>">
                <?= $b['nama_barang']; ?> (Rp <?= number_format($b['harga'],0,',','.'); ?>)
            </option>
        <?php } ?>
    </select>

    <input type="number" name="qty" placeholder="Qty" min="1" required>

    <button type="submit" name="tambah_produk" class="btn btn-tambah">
        Tambah
    </button>
</form>
</div>


<div class="card">
<h4>Daftar Produk</h4>

<table>
<tr>
    <th>No</th>
    <th>Produk</th>
    <th>Qty</th>
    <th>Harga</th>
    <th>Subtotal</th>
</tr>

<?php $no=1; while($d = mysqli_fetch_assoc($detail)) { ?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $d['nama_barang']; ?></td>
    <td><?= $d['qty']; ?></td>
    <td>Rp <?= number_format($d['harga'],0,',','.'); ?></td>
    <td>Rp <?= number_format($d['subtotal'],0,',','.'); ?></td>
</tr>
<?php } ?>

</table>
</div>