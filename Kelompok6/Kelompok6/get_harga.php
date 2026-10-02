<?php
$servername = "localhost:3308";
$username = "root";
$password = "";
$dbname = "kelompok6";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Mengambil data dari formulir
$kode_token = $_POST['kode_token'];
$nama = $_POST['nama'];
$nama_jalan = $_POST['nama_jalan'];
$desa = $_POST['desa'];
$kecamatan = $_POST['kecamatan'];
$kabupaten = $_POST['kabupaten'];
$barang = $_POST['barang'];
$jenis_barang = $_POST['jenis_barang'];
$jumlah_barang = $_POST['jumlah_barang'];
$harga = $_POST['harga'];

// Menyimpan data ke dalam database
$sql = "INSERT INTO pengiriman_barang (kode_token, nama, nama_jalan, desa, kecamatan, kabupaten, barang, jenis_barang, jumlah_barang, harga) 
        VALUES ('$kode_token', '$nama', '$nama_jalan', '$desa', '$kecamatan', '$kabupaten', '$barang', '$jenis_barang', '$jumlah_barang', '$harga')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("success" => true, "message" => "Data berhasil disimpan."));
} else {
    echo json_encode(array("success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error));
}

$conn->close();
?>
