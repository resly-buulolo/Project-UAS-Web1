<?php
include "koneksi.php"; // path diubah karena di luar folder

$data = mysqli_query($conn, "
    SELECT t.id_transaksi,
           t.tanggal,
           c.nama_customer,
           b.nama_barang,
           d.qty,
           d.harga,
           d.subtotal
    FROM transaksi_detail d
    LEFT JOIN transaksi t ON d.id_transaksi = t.id_transaksi
    LEFT JOIN barang b ON d.id_barang = b.id_barang
    LEFT JOIN customer c ON t.id_customer = c.id_customer
    ORDER BY t.id_transaksi DESC
");
?>

<style>
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: center;
}

th {
    background: #34495e;
    color: white;
}

h2 {
    color: #2c3e50;
    margin-bottom: 20px;
}
</style>

<h2>Laporan Penjualan</h2>

<table>
<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Customer</th>
    <th>Produk</th>
    <th>Qty</th>
    <th>Harga</th>
    <th>Subtotal</th>
</tr>

<?php 
$no = 1;
while($row = mysqli_fetch_assoc($data)) {
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $row['tanggal']; ?></td>
    <td><?= $row['nama_customer']; ?></td>
    <td><?= $row['nama_barang']; ?></td>
    <td><?= $row['qty']; ?></td>
    <td>Rp <?= number_format($row['harga']); ?></td>
    <td>Rp <?= number_format($row['subtotal']); ?></td>
</tr>
<?php } ?>
</table>