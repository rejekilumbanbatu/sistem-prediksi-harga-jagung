<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "kelompok"; 
// Buat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
