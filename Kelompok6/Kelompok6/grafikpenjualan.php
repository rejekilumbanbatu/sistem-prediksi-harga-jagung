<?php
session_start();

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

$servername = "localhost:3308";
$username = "root";
$password = "";
$dbname = "kelompok6";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM transaksi";
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
    <title>Tentang Kami - Prediksi Harga Komoditi Jagung</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/lux/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        .scrollable-table {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        .dataTables_length, .dataTables_paginate {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="#">
            Prediksi Harga<br>
            <small>Komoditi Pertanian Jagung</small>
        </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="Tentang_Kami.php">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item active"><a class="nav-link" href="transaksi.php">Tabel Transaksi</a></li> 
                        <li class="nav-item"><a class="nav-link" href="tabel.php">Tabel Harga</a></li> 
                    <?php elseif(isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
                        <li class="nav-item active"><a class="nav-link" href="transaksi.php">Tabel Transaksi</a></li>
                        <li class="nav-item"><a class="nav-link" href="tabel.php">Tabel Harga</a></li>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['role'])): ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['username']; ?> <span class="caret"></span></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="profile.php">Profile</a>
                                <a class="dropdown-item" href="#" onclick="showLogoutAlert()">Logout</a>
                            </div>
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

        <!-- Filter and search options -->
        <nav class="navbar navbar-light bg-light">
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" id="searchInput" placeholder="Cari Nomor Transaksi, Alamat, atau Penjual" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="searchTransactions()">Cari</button>
            </form>
        </nav>

        <!-- Filter options -->
        <div class="btn-group filter" role="group" aria-label="Filter by Seller">
            <button type="button" class="btn btn-secondary" onclick="filterBySeller('Petani')">Petani</button>
            <button type="button" class="btn btn-secondary" onclick="filterBySeller('Tokke Kecil')">Tokke Kecil</button>
        </div>

        <div class="btn-group filter" role="group" aria-label="Filter by Address">
            <button type="button" class="btn btn-secondary" onclick="filterByAddress('Balige')">Balige</button>
            <button type="button" class="btn btn-secondary" onclick="filterByAddress('Sitoluama')">Sitoluama</button>
            <button type="button" class="btn btn-secondary" onclick="filterByAddress('Porsea')">Porsea</button>
        </div>

        <!-- Show entries dropdown and pagination controls -->
        <div class="row">
            <div class="col-md-6">
                <div class="dataTables_length">
                    <label>
                        Show 
                        <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm" onchange="changeRowsPerPage(this.value)">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select> 
                        entries
                    </label>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                    <ul class="pagination">
                        <li class="paginate_button page-item previous disabled" id="dataTable_previous"><a href="#" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
                        <li class="paginate_button page-item active"><a href="#" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                        <li class="paginate_button page-item"><a href="#" aria-controls="dataTable" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                        <li class="paginate_button page-item"><a href="#" aria-controls="dataTable" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
                        <li class="paginate_button page-item next" id="dataTable_next"><a href="#" aria-controls="dataTable" data-dt-idx="4" tabindex="0" class="page-link">Next</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Scrollable table div -->
        <div class="scrollable-table">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Jenis Produk</th>
                        <th>Berat</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Penjual</th>
                        <?php if ($role === 'admin') : ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data as $index => $item) {
                        echo '<tr>';
                        echo '<td>' . ($index + 1) . '</td>';
                        echo '<td>' . $item['id_transaksi'] . '</td>';
                        echo '<td>' . $item['tanggal'] . '</td>';
                        echo '<td>' . $item['jam'] . '</td>';
                        echo '<td>' . $item['nama'] . '</td>';
                        echo '<td>' . $item['alamat'] . '</td>';
                        echo '<td>' . $item['jenis_produk'] . '</td>';
                        echo '<td>' . $item['berat'] . '</td>';
                        echo '<td>' . $item['harga'] . '</td>';
                        echo '<td>' . $item['total'] . '</td>';
                        echo '<td>' . $item['pembayaran'] . '</td>';
                        echo '<td>' . $item['status'] . '</td>';
                        echo '<td>' . $item['penjual'] . '</td>';
                        if ($role === 'admin') {
                            echo '<td>
                                <button class="btn btn-primary btn-sm" onclick="editTransaction(' . $item['id_transaksi'] . ')"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm" onclick="deleteTransaction(' . $item['id_transaksi'] . ')"><i class="fas fa-trash"></i></button>
                            </td>';
                        }
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
        <div id="pagination" class="pagination"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#dataTable').DataTable({
                "paging": true,
                "lengthMenu": [10, 25, 50, 100],
                "pageLength": 10,
                "searching": false,
                "info": false
            });
        });

        // Function to search transactions
        function searchTransactions() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("dataTable").getElementsByTagName("tbody")[0];
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                var found = false;
                for (var j = 1; j < tr[i].cells.length; j++) {
                    td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        // Function to filter transactions by seller
        function filterBySeller(seller) {
            var table, tr, td, i, txtValue;
            table = document.getElementById("dataTable").getElementsByTagName("tbody")[0];
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[12]; // Index 12 for Penjual
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase() === seller.toUpperCase()) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Function to filter transactions by address
        function filterByAddress(address) {
            var table, tr, td, i, txtValue;
            table = document.getElementById("dataTable").getElementsByTagName("tbody")[0];
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[5]; // Index 5 for Alamat
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(address.toUpperCase()) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Function to change rows per page
        function changeRowsPerPage(rows) {
            var table = $('#dataTable').DataTable();
            table.page.len(rows).draw();
        }

        function showLogoutAlert() {
            var confirmation = confirm("Apakah Anda yakin ingin keluar?");
            if (confirmation) {
                window.location.href = "logout.php"; // Ganti 'logout.php' dengan URL logout yang benar
            }
        }
    </script>
</body>
</html>
