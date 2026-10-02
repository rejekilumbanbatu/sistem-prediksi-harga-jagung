<?php
// get_data.php

// Buat koneksi ke database
$servername = "localhost:3306";
$username = "root";
$password = "root";
$dbname = "kelompok6";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel harga
$sql = "SELECT * FROM tabel_harga";
$result = $conn->query($sql);

// Cek jika ada data yang diambil
if ($result->num_rows > 0) {
    // Inisialisasi array untuk menyimpan data
    $data = array();

    // Ambil data dari hasil query dan simpan ke dalam array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Mengembalikan data sebagai JSON
    echo json_encode($data);
} else {
    echo "0 results";
}

// Tutup koneksi database
$conn->close();
?>
