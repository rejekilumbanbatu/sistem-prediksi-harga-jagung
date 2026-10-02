<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kelompok6";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari formulir
$kode_token = $_POST['kode_token'];
$nama = $_POST['nama'];
$barang = $_POST['barang'];
$jenis_barang = $_POST['jenis_barang'];
$jumlah_barang = $_POST['jumlah_barang'];
$harga = $_POST['harga'];

// Menyimpan alamat
$nama_jalan = $_POST['nama_jalan'];
$desa = $_POST['desa'];
$kecamatan = $_POST['kecamatan'];
$kabupaten = $_POST['kabupaten'];

// Query untuk menyimpan alamat
$sql_alamat = "INSERT INTO alamat (nama_jalan, desa, kecamatan, kabupaten)
VALUES ('$nama_jalan', '$desa', '$kecamatan', '$kabupaten')";

if ($conn->query($sql_alamat) === TRUE) {
    $alamat_id = $conn->insert_id; // Dapatkan ID alamat yang baru saja dimasukkan

    // Query untuk menyimpan data ke dalam tabel databarang dengan ID alamat yang sesuai
    $sql_databarang = "INSERT INTO databarang (kode_token, nama, barang, jenis_barang, jumlah_barang, harga, alamat_id)
    VALUES ('$kode_token', '$nama', '$barang', '$jenis_barang', '$jumlah_barang', '$harga', '$alamat_id')";

    if ($conn->query($sql_databarang) === TRUE) {
        echo "Data berhasil dimasukkan.";
    } else {
        echo "Error: " . $sql_databarang . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql_alamat . "<br>" . $conn->error;
}

// Menutup koneksi database
$conn->close();
?>
