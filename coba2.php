<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabel Harga Komoditi Jagung</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/lux/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Prediksi Harga Komoditi Jagung</a>
        </div>
    </nav>

    <!-- Container -->
    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Grafik Harga Komoditi Jagung</h4>
                <canvas id="priceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
    url: 'get_data.php',
    type: 'GET',
    success: function(data) {
        drawChart(data);
    },
    error: function(xhr, status, error) {
        console.error(error);
    }
});


function drawChart(data) {
    console.log(typeof data);
                const ctx = document.getElementById('priceChart').getContext('2d');
                const groupedData = data.reduce((acc, row) => {
                    if (!acc[row.Kode_PT]) acc[row.Kode_PT] = [];
                    acc[row.Kode_PT].push({ x: new Date(row.tanggal), y: parseFloat(row.Harga) });
                    return acc;
                }, {});

                const datasets = Object.keys(groupedData).map(kode_PT => ({
                    label: kode_PT,
                    data: groupedData[kode_PT],
                    borderColor: getRandomColor(),
                    fill: false
                }));

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        datasets: datasets
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day',
                                    tooltipFormat: 'YYYY-MM-DD',
                                    displayFormats: {
                                        day: 'YYYY-MM-DD'
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Tanggal'
                                }
                            },
                            y: {
                                beginAtZero: false,
                                title: {
                                    display: true,
                                    text: 'Harga'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return value.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                                    }
                                }
                            }
                        }
                    }
                });
            }

            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
        });
    </script>
</body>
</html>
