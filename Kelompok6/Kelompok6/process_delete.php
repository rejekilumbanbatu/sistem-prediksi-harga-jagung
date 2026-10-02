<?php
session_start();

$servername = "localhost:3308";
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
if (!isset($_SESSION['username'])) {
    // Jika tidak ada sesi, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Memeriksa apakah metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil ID data yang akan dihapus dari form
    $id = $_POST['id'];

    // Membuat dan mengeksekusi pernyataan SQL untuk menghapus data dengan ID yang sesuai
    $sql = "DELETE FROM tabel_harga WHERE ID = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil menghapus data, arahkan kembali ke halaman tabel.php
        header("Location: tabel.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menutup koneksi database
$conn->close();
?>
