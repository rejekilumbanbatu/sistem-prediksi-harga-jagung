<?php
session_start();

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$user_id = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : '';

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "kelompok6";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM transaksi";
if ($role == 'user') {
    $sql .= " WHERE id_user = $user_id";
}
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabel Transaksi - Prediksi Harga Komoditi Jagung</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/lux/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        thead th {
            position: sticky;
            top: 0;
            z-index: 0;
            background-color: #fff;
            font-weight: bold;
        }
        .scrollable-table {
            max-height: 400px;
            overflow-y: auto;
            overflow-x: auto;
            border: 2px solid #dee2e6;
            padding: 0px;
            white-space: nowrap;
        }
        .dataTables_length {
            margin-bottom: 0px;
        }
        .filter-group {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .filter, .search {
            flex: 1 1 45%;
            margin: 0 5px;
        }
        .search {
            flex: 1 1 100%;
            margin-bottom: 20px;
        }
        .filter button, .search button {
            transition: background-color 0.3s, transform 0.3s;
        }
        .filter button:hover, .search button:hover {
            background-color: #007bff;
            color: white;
        }
        .filter button:active, .search button:active {
            transform: scale(0.95);
        }
        @media (max-width: 768px) {
            .filter, .search {
                flex: 1 1 100%;
                margin-bottom: 10px;
            }
        }
        .navbar-brand img {
            height: 24px;
            margin-right: 5px;
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
                        <li class="nav-item active">
                            <a class="nav-link" href="transaksi.php">Tabel Transaksi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tabel.php">Tabel Harga</a>
                        </li>
                    <?php elseif(isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="transaksi.php">Tabel Transaksi</a>
                        </li>
                        <li class="nav-item">
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
                                <i class="fas fa-bell"></i>
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

    <div class="container mt-4">
        <h2>Data Transaksi</h2>

        <!-- Search options -->
        <div class="search">
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" id="searchInput" placeholder="Cari Nomor Transaksi, Alamat, atau Penjual" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="searchTransactions()">Cari</button>
            </form>
        </div>

        <!-- Filter options -->
        <div class="filter-group">
            <!-- Filter by Seller -->
            <div class="btn-group filter" role="group" aria-label="Filter by Seller">
                <button type="button" class="btn btn-secondary" onclick="filter('seller', 'Petani')">Petani</button>
                <button type="button" class="btn btn-secondary" onclick="filter('seller', 'Tokke Kecil')">Tokke Kecil</button>
            </div>

            <!-- Filter by Address -->
            <div class="btn-group filter" role="group" aria-label="Filter by Address">
                <button type="button" class="btn btn-secondary" onclick="filter('address', 'Balige')">Balige</button>
                <button type="button" class="btn btn-secondary" onclick="filter('address', 'Sitoluama')">Sitoluama</button>
                <button type="button" class="btn btn-secondary" onclick="filter('address', 'Porsea')">Porsea</button>
            </div>
        </div>

        <!-- Show Row Entries -->
        <div class="dataTables_length" id="dataTable_length">
            <label>Show 
                <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select> entries
            </label>
        </div>

        <div class="scrollable-table">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Nomor Transaksi</th>
                        <th>ID User</th>
                        <th>ID Admin</th>
                        <th>Tanggal Pembelian</th>
                        <th>Alamat</th>
                        <th>Nama Barang</th>
                        <th>Kuantitas</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Basah/Kering</th>
                        <th>Keterangan</th>
                        <th>Penjual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data as $item) {
                        echo '<tr>';
                        echo '<td>' . $item['id_transaksi'] . '</td>';
                        echo '<td>' . $item['nomor_transaksi'] . '</td>';
                        echo '<td>' . $item['id_user'] . '</td>';
                        echo '<td>' . $item['id_admin'] . '</td>';
                        echo '<td>' . $item['tanggal_pembelian'] . '</td>';
                        echo '<td>' . $item['alamat'] . '</td>';
                        echo '<td>' . $item['nama_barang'] . '</td>';
                        echo '<td>' . $item['kuantitas'] . '</td>';
                        echo '<td>' . $item['harga_satuan'] . '</td>';
                        echo '<td>' . $item['total_harga'] . '</td>';
                        echo '<td>' . $item['basah_kering'] . '</td>';
                        echo '<td>' . $item['keterangan'] . '</td>';
                        echo '<td>' . $item['penjual'] . '</td>';
                        echo '<td>
                            <button class="btn btn-primary btn-sm" onclick="printReceipt(' . $item['id_transaksi'] . ')"><i class="fas fa-print"></i></button>
                        </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function printReceipt(transactionId) {
            window.location.href = 'kwitansi.php?nomor_transaksi=' + transactionId;
        }

        function searchTransactions() {
            var input = document.getElementById('searchInput').value.toUpperCase();
            var table = document.getElementById('dataTable');
            var rows = table.getElementsByTagName('tr');

            for (var i = 1; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName('td');
                var match = false;

                for (var j = 0; j < cells.length; j++) {
                    if (cells[j].innerHTML.toUpperCase().indexOf(input) > -1) {
                        match = true;
                        break;
                    }
                }

                rows[i].style.display = match ? '' : 'none';
            }
        }

        function filter(column, value) {
            var table = document.getElementById('dataTable');
            var rows = table.getElementsByTagName('tr');

            for (var i = 1; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName('td');
                var match = false;

                for (var j = 0; j < cells.length; j++) {
                    if (cells[j].getAttribute('data-column') === column && cells[j].innerHTML.indexOf(value) > -1) {
                        match = true;
                        break;
                    }
                }

                rows[i].style.display = match ? '' : 'none';
            }
        }
    </script>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Tentang Kami</h5>
                    <p>Website ini menyediakan informasi terkini tentang harga komoditi jagung, serta prediksi harga yang dapat membantu para petani dan pelaku bisnis.</p>
                </div>
                <div class="col-md-4">
                    <h5>Kontak Kami</h5>
                    <ul class="list-unstyled">
                        <li><a href="mailto:info@komoditijagung.com"><i class="fas fa-envelope"></i> info@komoditijagung.com</a></li>
                        <li><a href="tel:+628123456789"><i class="fas fa-phone"></i> +62 812 3456 789</a></li>
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> Jl. Raya Jagung No.123, Indonesia</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Ikuti Kami</h5>
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; 2023 Prediksi Harga Komoditi Jagung. All rights reserved.</p>
</div>
</div>
</div>
</footer>
<!-- jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>

