<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Harga Produk</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f2f2f2; /* Warna latar belakang */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .grafik-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            justify-content: center; 
        }
        .grafik-wrapper {
            width: 400px; 
            height: 300px; 
            background-color: #ffffff; 
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            overflow: hidden; 
              }
    </style>
</head>
<body>

<?php
// Hubungkan ke database
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "kelompok6";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query untuk mengambil data dari tabel harga
    $query = "SELECT * FROM tabel_harga";
    $stmt = $conn->query($query);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Inisialisasi array untuk menyimpan data
    $datasets = [];

    // Memuat data dari tabel harga ke dalam array berdasarkan Kode_PT
    foreach ($data as $row) {
        $datasets[$row['Kode_PT']]['labels'][] = $row['Tanggal'];
        $datasets[$row['Kode_PT']]['data'][] = (int)$row['Harga'];
        $datasets[$row['Kode_PT']]['pt'] = $row['PT'];
    }

    // Menampilkan grafik untuk setiap Kode_PT
    echo "<div class='grafik-container'>";
    foreach ($datasets as $kode => $dataset) {
        echo "<div class='grafik-wrapper'>";
        echo "<h2 style='text-align: center; margin-top: 10px;'>Grafik {$dataset['pt']}</h2>";
        echo "<canvas id='grafik_$kode' width='400' height='200'></canvas>";
        echo "<script>
            var ctx = document.getElementById('grafik_$kode').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: " . json_encode($dataset['labels']) . ", // Memasukkan data tanggal sebagai labels
                    datasets: [{
                        label: 'Harga Jagung',
                        data: " . json_encode($dataset['data']) . ",
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += 'Rp ' + context.parsed.y.toLocaleString();
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        </script>";
        echo "</div>";
    }
    echo "</div>";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>

</body>
</html>
