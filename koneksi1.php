<?php
// Konfigurasi koneksi database
$servername = "localhost:3306"; 
$username = "root"; 
$password = ""; 
$dbname = "kelompok6";  

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set karakter encoding menjadi UTF-8
$conn->set_charset("utf8");
?>
