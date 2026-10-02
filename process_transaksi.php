<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost3006";
$username = "root";
$password = "";
$dbname = "kelompok6";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// ID user yang sedang login
$id_user = $_SESSION['id']; // Pastikan Anda memiliki session id_user setelah user login

// ID admin (misalnya, ID 23)
$id_admin = 23;

// Ambil data dari form
$alamat = $_POST['alamat'];
$nama_barang = $_POST['nama_barang'];
$kuantitas = $_POST['kuantitas'];
$harga_satuan = $_POST['harga_satuan'];
$basah_kering = $_POST['basah_kering'];
$keterangan = $_POST['keterangan'];

// Query untuk memasukkan data ke dalam tabel transaksi
$sql = "INSERT INTO transaksi (id_user, id_admin, tanggal_pembelian, alamat, nama_barang, kuantitas, harga_satuan, total_harga, basah_kering, keterangan, penjual) 
        VALUES ('$id_user', '$id_admin', NOW(), '$alamat', '$nama_barang', '$kuantitas', '$harga_satuan', '$kuantitas' * '$harga_satuan', '$basah_kering', '$keterangan', 'Petani')";

if ($conn->query($sql) === TRUE) {
    // Data berhasil dimasukkan, tambahkan kode untuk menampilkan notifikasi kepada admin
    // Misalnya, kirim email atau tampilkan pesan di dashboard admin

    // Redirect kembali ke halaman transaksi
    header("Location: transaksi.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
