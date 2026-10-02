<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    // Jika tidak ada sesi, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil ID admin yang sedang login dari sesi
$id_admin = $_SESSION['id'];

// Tangkap data yang dikirimkan melalui form
$tanggal = $_POST['tanggal'];
$harga = $_POST['Harga'];
$pt = $_POST['PT'];
$kode_pt = $_POST['Kode_PT'];

// Buat koneksi ke database
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "kelompok6";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Buat dan eksekusi pernyataan SQL untuk memasukkan data baru ke dalam tabel harga
$sql = "INSERT INTO tabel_harga (id_admin, Tanggal, Harga, PT, Kode_PT) VALUES ('$id_admin', '$tanggal', '$harga', '$pt', '$kode_pt')";

if ($conn->query($sql) === TRUE) {
    // Jika berhasil memasukkan data, atur pesan keberhasilan dalam sesi
    $_SESSION['success_message'] = "Data berhasil ditambahkan.";
} else {
    // Jika gagal memasukkan data, atur pesan kegagalan dalam sesi
    $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi database
$conn->close();

// Redirect kembali ke halaman tabel.php
header("Location: tabel.php");
exit();
?>
