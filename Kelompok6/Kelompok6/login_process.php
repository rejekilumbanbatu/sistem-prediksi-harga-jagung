<?php
// Koneksi ke database
$servername = "localhost:3308";
$username = "root";
$password = "";
$dbname = "kelompok6";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari formulir login
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];
$token = isset($_POST['token']) ? $_POST['token'] : null;

// Query SQL untuk menyimpan data ke database
$sql = "INSERT INTO users (email, password, role, token) VALUES ('$email', '$password', '$role', '$token')";

if ($conn->query($sql) === TRUE) {
    if ($role === "user") {
        // Jika peran yang dipilih adalah "user", arahkan ke halaman tabel.php
        header("Location: tabel.php");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
    } else {
        // Jika peran yang dipilih bukan "user", arahkan ke halaman form_admin.php
        header("Location: form_admin.php");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
