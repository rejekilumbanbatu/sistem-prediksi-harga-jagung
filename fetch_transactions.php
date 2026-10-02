<?php
include 'koneksi1.php';

// Query untuk mengambil data transaksi dari tabel
$sql = "SELECT * FROM transaksi";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Loop through each row
    while ($row = $result->fetch_assoc()) {
        // Append row to data array
        $data[] = $row;
    }
}

// Close connection
$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
