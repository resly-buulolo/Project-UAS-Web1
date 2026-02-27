<?php
$host = "Localhost"; // alamat server database (biasanya localhost)
$user = "root"; // username untuk login ke database
$password = ""; //password untuk login (biasanya kosong untuk localhost)
$dbname = "db_kasir"; // nama database yang ingin diakses

// membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_eror);
}
//echo "Koneksi berhasil";
?>