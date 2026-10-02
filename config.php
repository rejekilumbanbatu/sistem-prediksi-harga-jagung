<?php
$servername = "localhost:3306";
$username = "root"; 
$password = ""; 
$database = "kelompok6"; 
// Buat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
