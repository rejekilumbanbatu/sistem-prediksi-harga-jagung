<?php
session_start();

// Koneksi database
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "kelompok6";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data total penjualan per daerah
$sql = "SELECT 
            CASE 
                WHEN alamat LIKE '%Balige%' THEN 'Balige'
                WHEN alamat LIKE '%Sitoluama%' THEN 'Sitoluama'
                WHEN alamat LIKE '%Porsea%' THEN 'Porsea'
                ELSE 'Lainnya'
            END AS daerah,
            SUM(total_harga) AS total_penjualan
        FROM transaksi
        GROUP BY daerah";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Penjualan Jagung per Daerah</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/lux/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Grafik Total Penjualan Jagung per Daerah</h2>
        <canvas id="salesChart"></canvas>
        <a href="tabel.php" class="btn btn-primary mt-4">Kembali ke Tabel Harga</a>
    </div>

    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const data = <?php echo json_encode($data); ?>;

        const labels = data.map(row => row.daerah);
        const totals = data.map(row => parseFloat(row.total_penjualan));

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: totals,
                    backgroundColor: ['#FF6384','#36A2EB','#FFCE56','#8AFF33'],
                    borderColor: ['#FF6384','#36A2EB','#FFCE56','#8AFF33'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                            }
                        },
                        title: {
                            display: true,
                            text: 'Total Penjualan'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Daerah'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
