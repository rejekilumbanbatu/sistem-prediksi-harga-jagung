<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost:3306";
$username = "root"; 
$password = ""; 
$database = "kelompok6"; 

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT Kode_PT, Tanggal, Harga FROM tabel_harga";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Ubah format tanggal dari "YYYY-MM-DD" ke "dd-mm-YYYY"
        $row['Tanggal'] = date("d-m-Y", strtotime($row['Tanggal']));
        $data[] = $row;
    }
}

$conn->close();

echo json_encode($data);
?>
