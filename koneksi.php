<?php
$host = "localhost:3306"; 
$username = "root"; 
$password = ""; 
$database = "kelompok6"; 


$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
