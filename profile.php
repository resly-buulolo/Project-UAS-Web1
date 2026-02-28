<?php
// profile.php
?>

<style>
.profile-container {
    width: 500px;
    margin: 40px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    font-family: Arial, sans-serif;
    text-align: center;
}

.profile-container h2 {
    margin-bottom: 20px;
    color: #2c3e50;
}

.profile-img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #3498db;
    margin-bottom: 20px;
}

.profile-item {
    margin-bottom: 15px;
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

.profile-item strong {
    display: inline-block;
    width: 140px;
    color: #34495e;
}

.profile-footer {
    text-align: center;
    margin-top: 20px;
}

.profile-footer a {
    text-decoration: none;
    background: #3498db;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
}

.profile-footer a:hover {
    background: #2980b9;
}
</style>

<div class="profile-container">
    <h2>My Profile</h2>

    <!-- Foto Profil -->
    <img src="uploads/resly.jpg" alt="Foto Profil" class="profile-img">

    <div class="profile-item">
        <strong>Nama</strong>: Resly Buulolo
    </div>

    <div class="profile-item">
        <strong>Mata Kuliah</strong>: Pemrograman Web1
    </div>

    <div class="profile-item">
        <strong>Tahun</strong>: 2026
    </div>

    <div class="profile-item">
        <strong>Project</strong>: Sistem Penjualan Berbasis PHP & MySQL
    </div>

    <div class="profile-footer">
        <a href="dashboard.php?page=home">Kembali ke Dashboard</a>
    </div>
</div>