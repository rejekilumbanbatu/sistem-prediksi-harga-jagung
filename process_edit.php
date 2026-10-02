<?php
session_start();

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "kelompok6";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah ada sesi yang aktif
if (!isset($_SESSION['id_admin'])) {
    // Jika tidak ada sesi, arahkan ke halaman login
    header("Location: tabel.php");
    exit();
}

// Mengambil ID admin yang sedang login dari sesi
$id_admin = $_SESSION['id_admin'];

// Memeriksa apakah metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data yang dikirim melalui form
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $harga = $_POST['Harga'];
    $pt = $_POST['PT'];
    $kode_pt = $_POST['Kode_PT'];

    // Membuat dan mengeksekusi pernyataan SQL untuk memperbarui data dalam tabel harga
    $sql = "UPDATE tabel_harga SET Tanggal='$tanggal', Harga='$harga', PT='$pt', Kode_PT='$kode_pt' WHERE ID='$id' AND id_admin='$id_admin'";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil memperbarui data, arahkan kembali ke halaman tabel.php
        header("Location: tabel.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menutup koneksi database
$conn->close();
?>
