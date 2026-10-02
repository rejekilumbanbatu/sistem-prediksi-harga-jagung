
<?php
session_start();

if (isset($_SESSION['success_message'])) {
    // Tampilkan pesan
    echo "<div style='background-color: #dff0d8; color: #3c763d; padding: 10px; margin-bottom: 15px;'>".$_SESSION['success_message']."</div>";

    // Hapus pesan dari session agar tidak ditampilkan lagi
    unset($_SESSION['success_message']);
}

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "kelompok6";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

$sql = "SELECT * FROM tabel_harga";
$result = $conn->query($sql);

$data = array();
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
    <!-- CSS Bootstrap dan DataTables -->
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/lux/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>


    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - Prediksi Harga Komoditi Jagung</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- CSS kustom -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .about-header {
            text-align: center;
            padding: 50px 0;
            background-color: #f8f9fa;
        }
        .about-header h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .about-header p {
            font-size: 18px;
            color: #666;
        }
        .about-content {
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .about-section {
            margin-bottom: 30px;
        }
        .about-section h3 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .about-section p {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .team {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .team-member {
            flex: 1 1 300px;
            margin: 20px;
            text-align: center;
        }
        .team-member img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            margin-bottom: 15px;
        }
        .team-member h4 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .team-member p {
            font-size: 14px;
            color: #666;
        }
        .footer {
    background-color: #343a40; /* Warna latar belakang footer */
    color: #ffffff; /* Warna teks footer */
    padding-top: 30px;
    padding-bottom: 30px;
}

.footer h5 {
    color: #ffffff; /* Warna teks judul footer */
}

.footer p {
    color: #ffffff; /* Warna teks isi footer */
    margin-bottom: 10px;
}

.footer ul li a {
    color: #ffffff; /* Warna tautan footer */
}

.footer ul li a:hover {
    color: #cccccc; /* Warna tautan footer saat dihover */
}

.footer p.mb-0 {
    margin-bottom: 0; 
}

        .navbar-brand img {
            height: 24px; /* Sesuaikan dengan tinggi font */
            margin-right: 5px;
        }
        .table-responsive {
            max-height: 500px; /* Atur tinggi maksimum tabel sesuai kebutuhan */
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid" style="padding-right: 0; padding-left: 0;">
            <a class="navbar-brand" href="#">
                <img src="./img/logo.jpg" alt="Logo" /> Prediksi Harga<br>
                <small>Komoditi Pertanian Jagung</small>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Tentang_Kami.php">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontak.php">Kontak</a>
                    </li>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="transaksi.php">Tabel Transaksi</a>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link" href="tabel.php">Tabel Harga</a>
                        </li> 
                    <?php elseif(isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="transaksi.php">Tabel Transaksi</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="tabel.php">Tabel Harga</a>
                        </li>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['username'])): ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php echo $_SESSION['username']; ?> <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="profile.php">Profile</a>
                                <a class="dropdown-item" href="#" onclick="showLogoutAlert()">Logout</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-bell"></i> <!-- Icon lonceng untuk notifikasi -->
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Container -->
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
            <h4 class="card-title">
            <a href="form_tambah.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </h4>
                <h4 class="card-title">Tabel Harga Komoditi Jagung</h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Harga</th>
                                <th>PT</th>
                                <th>Kode_PT</th>
                                <?php if ($role === 'admin') : ?>
                                    <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $row) : ?>
                                <tr>
                                    <td><?php echo $row['tanggal']; ?></td>
                                    <td><?php echo $row['Harga']; ?></td>
                                    <td><?php echo $row['PT']; ?></td>
                                    <td><?php echo $row['Kode_PT']; ?></td>
                                    <?php if ($role === 'admin') : ?>
                                        <td>
                                            <!-- Edit and delete buttons -->
                                            <div class="d-flex">
                                                <!-- Edit link -->
                                                <a href="form_edit.php?id=<?php echo $row['ID']; ?>" class="btn btn-primary btn-sm mr-2">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <!-- Delete form -->
                                                <form method="post" action="process_delete.php">
                                                    <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       <!-- Container -->
<div class="container mt-4">
    <!-- ... -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Grafik Harga Komoditi Jagung</h4>
            <div class="btn-group" role="group" aria-label="PT selection">
                <?php
                $unique_pts = array_unique(array_column($data, 'PT'));
                foreach ($unique_pts as $pt) {
                    echo "<button type='button' class='btn btn-secondary pt-link' data-pt='$pt'>$pt</button>";
                }
                ?>
            </div>
            <canvas id="priceChart" style="height:400px;"></canvas>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    $(document).ready(function() {
        // ... Logika DataTables

        const data = <?php echo json_encode($data); ?>;
        const groupedData = data.reduce((acc, row) => {
            if (!acc[row.PT]) acc[row.PT] = [];
            acc[row.PT].push({ x: row.tanggal, y: parseFloat(row.Harga) });
            return acc;
        }, {});

        const ctx = document.getElementById('priceChart').getContext('2d');
        let chart = null;

        function updateChart(pt) {
            const ptData = groupedData[pt] || [];
            const datasets = [{
                label: pt,
                data: ptData,
                borderColor: getRandomColor(),
                fill: false
            }];

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: datasets
                },
                options: {
                    scales: {
                        x: {
                            type: 'time', // Sesuaikan dengan data tanggal
                            time: {
                                unit: 'day'
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

        $('.pt-link').click(function() {
            const pt = $(this).data('pt');
            updateChart(pt);
        });

        // Initial chart
        if ($('.pt-link').length > 0) {
            const initialPt = $('.pt-link').first().data('pt');
            updateChart(initialPt);
        }
    });

    function showLogoutAlert() {
        var confirmation = confirm("Apakah Anda yakin ingin keluar?");
        if (confirmation) {
            window.location.href = "logout.php"; // Ganti 'logout.php' dengan URL logout yang benar
        }
    }
    $(document).ready(function() {
    // Inisialisasi DataTables
    $('#dataTable').DataTable({
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ], // Menentukan opsi untuk "Show [n] entries"
        "pageLength": 10 // Menentukan jumlah baris yang ditampilkan secara default
    });
});


</script>
<script>
    $(document).ready(function() {
        $('.dropdown-toggle').on('click', function() {
            $(this).next('.dropdown-menu').toggleClass('show');
        });
    });
</script>
<footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Prediksi Harga Komoditi Pertanian Jagung</h5>
                    <p>Proyek prediksi harga jagung ini bertujuan untuk memberikan informasi mengenai harga jagung di berbagai daerah, membantu petani dan pedagang dalam mengambil keputusan.</p>
                </div>
                <div class="col-md-4">
                    <h5>Kontak Kami</h5>
                    <p>Email: info@prediksihargajagung.com</p>
                    <p>Telepon: +62 123 456 789</p>
                </div>
                <div class="col-md-4">
                    <h5>Ikuti Kami</h5>
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="text-center mb-0">&copy; 2023 Prediksi Harga Komoditi Pertanian Jagung. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>


