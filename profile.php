<?php
session_start();

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "kelompok6";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Ambil data transaksi dari database
$sql_transactions = "SELECT * FROM transaksi WHERE id_user = ?";
$stmt_transactions = $conn->prepare($sql_transactions);
$stmt_transactions->bind_param("i", $user['id']);
$stmt_transactions->execute();
$result_transactions = $stmt_transactions->get_result();
$transactions = array(); // Deklarasi variabel transactions
while ($row = $result_transactions->fetch_assoc()) {
    $transactions[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil - Prediksi Harga Komoditi Jagung</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/lux/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f3f3;
        }
        .profile-header {
            text-align: center;
            padding: 20px 0;
            background-color: #1b7c81;
            color: #fff;
        }
        .profile-header h2 {
            font-size: 35px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .profile-header small {
            font-size: 20px;
            color: #d4d4d4;
        }
        .profile-header p {
            font-size: 20px;
            color: #d4d4d4;
        }
        .profile-details {
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            border-radius: 10px;
        }
        .profile-details h3 {
            font-size: 30px;
            margin-bottom: 20px;
            color: #1b7c81;
        }
        .profile-details p {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }
        .profile-actions {
            margin-top: 20px;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            padding-top: 30px;
            padding-bottom: 30px;
        }
        .footer h5 {
            color: #fff;
        }
        .footer p {
            color: #fff;
            margin-bottom: 10px;
        }
        .footer ul li a {
            color: #fff;
        }
        .footer ul li a:hover {
            color: #ccc;
        }
        .footer p.mb-0 {
            margin-bottom: 0; 
        }
        .navbar-brand img {
            height: 24px;
            margin-right: 5px;
        }
        @media (min-width: 768px) {
            .profile-details {
                display: flex;
                justify-content: space-between;
            }
            .profile-details > div {
                width: 48%;
            }
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



    <!-- Profile Header -->
    <div class="profile-header">
        <div class="container">
            <h2><?php echo htmlspecialchars($user['username']); ?></h2>
            <small><?php echo htmlspecialchars($user['email']); ?></small>
            <p><?php echo htmlspecialchars($user['alamat']); ?></p>
        </div>
    </div>

    <div class="container">
    <div class="profile-details">
        <!-- Informasi Akun -->
        <div>
            <h3>Informasi Akun</h3>
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']);?></div>
            <?php endif; ?>
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <div>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Nama Lengkap:</strong> <?php echo htmlspecialchars($user['nama_lengkap']); ?></p>
                <p><strong>Alamat:</strong> <?php echo htmlspecialchars($user['alamat']); ?></p>
                <p><strong>Bio:</strong> <?php echo htmlspecialchars($user['bio']); ?></p>
            </div>
            <div class="profile-actions">
                <a href="edit_profil.php" class="btn btn-primary">Edit Profil</a>
            </div>
        </div>
        <!-- Informasi Penjualan -->
        <div>
            <h3>Informasi Penjualan</h3>
            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nomor Transaksi</th>
                            <th>Tanggal Pembelian</th>
                            <th>Kuantitas</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through transactions -->
                        <?php foreach($transactions as $transaction): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($transaction['nomor_transaksi']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['tanggal_pembelian']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['kuantitas']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['harga_satuan']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['total_harga']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['keterangan']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showLogoutAlert() {
            var confirmation = confirm("Apakah Anda yakin ingin keluar?");
            if (confirmation) {
                window.location.href = "logout.php"; // Ganti 'logout.php' dengan URL logout yang benar
            }
        }
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
