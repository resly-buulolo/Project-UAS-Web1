<?php
include $_SERVER['DOCUMENT_ROOT'] . '/PENJUALAN03/koneksi.php';
 
if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama_customer'];
    $email  = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_hp  = $_POST['no_hp'];
 
    mysqli_query($conn, "
        INSERT INTO customer
        (nama_customer, email, alamat, no_hp)
        VALUES
        ('$nama', '$email', '$alamat', '$no_hp')
    ");
 
    header("Location: dashboard.php?page=customer");
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
 
    input, textarea {
        width: 100%;
        background-color: white;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
 
    textarea {
        resize: vertical;
    }
 
    input:focus, textarea:focus {
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
    <h3>Tambah Customer</h3>
    <form method="post">
 
        <div class="form-group">
            <label>Nama Customer</label>
            <input type="text" name="nama_customer" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
 
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" rows="3" required></textarea>
        </div>
 
        <div class="form-group">
            <label>No HP</label>
            <input type="text" name="no_hp" required>
        </div>
 
        <button type="submit" name="simpan" class="btn btn-tambah">Simpan</button>
        <a href="dashboard.php?page=customer" class="btn btn-hapus">Batal</a>
 
    </form>
</div>
