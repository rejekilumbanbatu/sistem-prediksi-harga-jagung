<?php
session_start();

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "kelompok6";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $bio = $_POST['bio'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE users SET username = ?, nama_lengkap = ?, bio = ?, email = ?, alamat = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $new_username, $nama_lengkap, $bio, $email, $alamat, $username);

    if ($stmt->execute()) {
        $_SESSION['username'] = $new_username; // Update the session with the new username
        $_SESSION['success'] = "Profil berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat memperbarui profil.";
    }
    header("Location: profile.php");
    exit();
}

$conn->close();
?>
