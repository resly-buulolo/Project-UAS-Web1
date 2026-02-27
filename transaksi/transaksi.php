<?php

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

include 'koneksi.php';

$data = mysqli_query($conn, "
    SELECT 
        t.*, 
        c.nama_customer,
        GROUP_CONCAT(b.nama_barang SEPARATOR ', ') AS produk
    FROM transaksi t
    LEFT JOIN customer c ON t.id_customer = c.id_customer
    LEFT JOIN transaksi_detail td ON t.id_transaksi = td.id_transaksi
    LEFT JOIN barang b ON td.id_barang = b.id_barang
    GROUP BY t.id_transaksi
    ORDER BY t.id_transaksi DESC
");
?>

<style>
.card {
    background: white;
    padding: 20px;  
    border-radius: 6px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.btn {
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 4px;
    color: white;
    font-size: 14px;
}

.btn-tambah {
    background: #27ae60;
}

.btn-edit {
    background: #2980b9;
}

.btn-hapus {
    background: #c0392b;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

th {
    background: #f8f8f8;
}
</style>

<div class="card">
    <div class="card-header">
        <h3>Data Transaksi</h3>
        <a href="dashboard.php?page=tambah_transaksi" class="btn btn-tambah">
            + Transaksi Baru
        </a>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Customer</th>
            <th>Produk</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1; ?>
        <?php while ($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['tanggal']; ?></td>
            <td><?= $row['nama_customer']; ?></td>
            <td><?= $row['produk'] ? $row['produk'] : '-'; ?></td>
            <td>Rp <?= number_format($row['total'],0,',','.'); ?></td>
            <td>
                <a href="dashboard.php?page=edit_transaksi&id=<?= $row['id_transaksi']; ?>" 
                   class="btn btn-edit">
                   Edit
                </a>

                <a href="dashboard.php?page=hapus_transaksi&id=<?= $row['id_transaksi']; ?>"
                   class="btn btn-hapus"
                   onclick="return confirm('Yakin hapus transaksi ini?')">
                   Hapus
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>