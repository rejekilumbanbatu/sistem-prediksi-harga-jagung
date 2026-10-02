<?php
// Koneksi ke database (ganti dengan detail koneksi Anda)
$servername = "localhost:3308";
$username = "root";
$password = "";
$dbname = "kelompok6";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data transaksi
$sql = "SELECT tanggal_pembelian, id_admin, harga_satuan FROM transaksi";

$result = $conn->query($sql);

$transactions = array();

if ($result->num_rows > 0) {
    // Menyusun data transaksi dalam array
    while($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
}

// Mengembalikan data transaksi dalam format JSON
echo json_encode($transactions);

$conn->close();
?>
