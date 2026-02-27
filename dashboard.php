<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard POLGANMART</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f4f4;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            height: 100vh;
            background: #2c3e50;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar h2 {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        /* Header */
        .header {
            height: 60px;
            background: white;
            padding: 10px 20px;
            margin-left: 220px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .profile-btn {
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 20px;
            background: #3498db;
            color: white;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            min-width: 150px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .dropdown-content a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }

        .dropdown-content a:hover {
            background: #f0f0f0;
        }

        /* Content */
        .content {
            margin-left: 220px;
            padding: 20px;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h2>Dashboard</h2>
    <a href="dashboard.php?page=home">Home</a>
    <a href="dashboard.php?page=listproducts">List Produk</a>
    <a href="dashboard.php?page=customer">Customer</a>
    <a href="dashboard.php?page=transaksi">Transaksi</a>
    <a href="dashboard.php?page=laporan">Laporan</a>
</div>

<div class="header">
    <div class="dropdown">
        <div class="profile-btn" onclick="toggleMenu()">Profile ▾</div>
        <div class="dropdown-content" id="profileMenu">
            <a href="dashboard.php?page=profile">My Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<div class="content">

<?php
$page = $_GET['page'] ?? 'home';

switch ($page) {

    // ===== HOME =====
    case 'home':
        include "pages/home.php";
        break;

    // ===== PRODUK =====
    case 'listproducts':
        include "pages/listproducts.php";
        break;
    case 'tambah_produk':
        include "pages/tambah_produk.php";
        break;
    case 'edit_produk':
        include "pages/edit_produk.php";
        break;
    case 'hapus_produk':
        include "pages/hapus_produk.php";
        break;

    // ===== CUSTOMER =====
    case 'customer':
        include "pelanggan/customer.php";
        break;
    case 'tambah_customer':
        include "pelanggan/tambah_customer.php";
        break;
    case 'edit_customer':
        include "pelanggan/edit_customer.php";
        break;
    case 'hapus_customer':
        include "pelanggan/hapus_customer.php";
        break;

    // ===== TRANSAKSI =====
    case 'transaksi':
        include "transaksi/transaksi.php";
        break;
    case 'tambah_transaksi':
        include "transaksi/tambah_transaksi.php";
        break;
    case 'edit_transaksi':
        include "transaksi/edit_transaksi.php";
        break;
    case 'hapus_transaksi':
        include "transaksi/hapus_transaksi.php";
        break;


    default:
        include "pages/home.php";
}
?>

</div>

<script>
function toggleMenu() {
    var menu = document.getElementById("profileMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

window.onclick = function(event) {
    if (!event.target.matches('.profile-btn')) {
        document.getElementById("profileMenu").style.display = "none";
    }
}
</script>

</body>
</html>