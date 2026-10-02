<?php
session_start();

// =====================
// KONEKSI DATABASE
// =====================
$conn = new mysqli("localhost:3306", "root", "", "kelompok6");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// =====================
// VALIDASI POST
// =====================
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Akses tidak sah");
}

// =====================
// AMBIL DATA FORM
// =====================
$nomor_transaksi   = $_POST['nomor_transaksi'] ?? '';
$id_harga_form     = $_POST['id_harga'] ?? '';
$id_user           = $_POST['id_user'] ?? '';
$id_admin          = $_POST['id_admin'] ?? '';
$tanggal_pembelian = $_POST['tanggal_pembelian'] ?? date("Y-m-d");
$alamat            = $_POST['alamat'] ?? '';
$nama_barang       = $_POST['nama_barang'] ?? '';
$kuantitas         = $_POST['kuantitas'] ?? 0;
$basah_kering      = $_POST['basah_kering'] ?? '';
$keterangan        = $_POST['keterangan'] ?? '';
$penjual           = $_POST['penjual'] ?? '';

// =====================
// VALIDASI WAJIB
// =====================
if ($kuantitas <= 0) {
    die("Kuantitas tidak valid");
}

if (empty($nama_barang) || empty($alamat)) {
    die("Data wajib belum diisi");
}

// =====================
// AMBIL HARGA TERBARU DARI DB
// (LEBIH AMAN DARI FORM)
// =====================
$sql = "SELECT ID, Harga 
        FROM tabel_harga 
        ORDER BY tanggal DESC 
        LIMIT 1";

$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Data harga di tabel_harga belum ada");
}

$row = $result->fetch_assoc();
$id_harga     = $row['ID'];
$harga_satuan = $row['Harga'];

// =====================
// HITUNG TOTAL HARGA
// =====================
$total_harga = $kuantitas * $harga_satuan;

// =====================
// INSERT TRANSAKSI
// =====================
$stmt = $conn->prepare("
INSERT INTO transaksi (
    nomor_transaksi,
    id_harga,
    id_user,
    id_admin,
    tanggal_pembelian,
    alamat,
    nama_barang,
    kuantitas,
    harga_satuan,
    total_harga,
    basah_kering,
    keterangan,
    penjual
) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)
");

$stmt->bind_param(
    "siiisssddssss",
    $nomor_transaksi,
    $id_harga,
    $id_user,
    $id_admin,
    $tanggal_pembelian,
    $alamat,
    $nama_barang,
    $kuantitas,
    $harga_satuan,
    $total_harga,
    $basah_kering,
    $keterangan,
    $penjual
);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "✅ Transaksi berhasil disimpan";
    header("Location: transaksi.php");
    exit();
} else {
    echo "Gagal simpan: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
