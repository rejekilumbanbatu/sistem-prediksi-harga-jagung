<?php
session_start();

// Database connection parameters
$servername = "localhost:3306";
$username = "root";
$password = "";
$database = "kelompok6";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan jumlah transaksi untuk menentukan nomor transaksi berikutnya
$sql_transaksi = "SELECT COUNT(*) as count FROM transaksi";
$result_transaksi = $conn->query($sql_transaksi);
$count_transaksi = $result_transaksi->fetch_assoc()['count'];
$next_transaction_number = "TRX" . str_pad($count_transaksi + 1, 3, '0', STR_PAD_LEFT);

// Mendapatkan tanggal hari ini
$current_date = date("Y-m-d");

// Mendapatkan ID Harga berdasarkan tanggal hari ini
$sql_id_harga = "SELECT ID FROM tabel_harga WHERE tanggal = '$current_date'";
$result_id_harga = $conn->query($sql_id_harga);
$id_harga = $result_id_harga->fetch_assoc()['ID'];

// Mendapatkan harga satuan dari tabel_harga berdasarkan ID Harga
$sql_harga_satuan = "SELECT Harga FROM tabel_harga WHERE ID = '$id_harga'";
$result_harga_satuan = $conn->query($sql_harga_satuan);
$harga_satuan = "Harga Satuan Tidak Ditemukan";
if ($result_harga_satuan && $result_harga_satuan->num_rows > 0) {
    $harga_satuan = $result_harga_satuan->fetch_assoc()['Harga'];
}


// Mendapatkan ID pengguna dari session
$id_user = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Mendapatkan nama penjual dari tabel users berdasarkan id_user
$sql_penjual = "SELECT penjual FROM users WHERE id = '$id_user'";
$result_penjual = $conn->query($sql_penjual);
$penjual = "Nama Pengguna Tidak Ditemukan";
if ($result_penjual && $result_penjual->num_rows > 0) {
    $penjual = $result_penjual->fetch_assoc()['penjual'];
}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        /* Mengurangi tinggi slider */
        .carousel-item img {
            height: 500px;
            object-fit: cover;
        }
        /* Mengubah tampilan background div harga terbaru */
        .content {
            background-color: #87CEEB; /* Warna biru langit */
            padding: 50px 0; /* Beri ruang di atas dan bawah */
        }
        /* Kode CSS lainnya */
        .carousel {
            margin-top: 50px;
            margin-bottom: 50px;
        }
        /* Kode CSS lainnya */
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

        .thumbnails-container .thumbnail {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease-in-out;
        }
        .thumbnails-container .thumbnail:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }
        .thumbnails-container .thumbnail img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .thumbnails-container .thumbnail .caption {
            padding: 20px;
            text-align: center;
        }
        .thumbnails-container .thumbnail .caption h3 {
            font-size: 24px;
            margin-bottom: 15px;
        }
        .thumbnails-container .thumbnail .caption p {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .btn-read-more {
            background-color: #007bff;
            color: #fff;
            border-radius: 20px;
            padding: 10px 20px;
            transition: background-color 0.3s ease-in-out;
        }
        .btn-read-more:hover {
            background-color: #0056b3;
        }
    
        .navbar-brand img {
            height: 24px; /* Sesuaikan dengan tinggi font */
            margin-right: 5px;
        }
        .carousel-item img {
    width: 100%;
    height: auto;
    object-fit: contain;
    }

    .carousel-caption a.btn {
    padding: 8px 20px; /* Sesuaikan padding sesuai kebutuhan */
    border-radius: 20px; /* Menjadikan tombol menjadi bundar */
    font-size: 16px; /* Sesuaikan ukuran teks sesuai kebutuhan */
    line-height: 1.5; /* Sesuaikan tinggi baris sesuai kebutuhan */
}

        .carousel-item img {
            object-fit: cover;
            height: 100vh;
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
                    <li class="nav-item active">
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


    <!-- Form Penjualan -->
    <div class="container mt-4">
        <h2>Form Penjualan Jagung</h2>
        <form action="process_penjualan.php" method="post">
            <!-- Nomor Transaksi -->
            <div class="form-group">
                <label for="nomor_transaksi">Nomor Transaksi:</label>
                <input type="text" class="form-control" id="nomor_transaksi" name="nomor_transaksi" value="<?php echo $next_transaction_number; ?>" readonly>
            </div>

            <!-- ID Harga -->
            <input type="hidden" id="id_harga" name="id_harga" value="<?php echo $id_harga; ?>">

            <!-- ID User -->
            <input type="hidden" id="id_user" name="id_user" value="<?php echo $id_user; ?>">

            <!-- ID Admin -->
            <input type="hidden" id="id_admin" name="id_admin" value="23">

            <!-- Tanggal Pembelian (Current Date) -->
            <div class="form-group">
                <label for="tanggal_pembelian">Tanggal Pembelian:</label>
                <input type="text" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" value="<?php echo date("Y-m-d"); ?>" readonly>
            </div>

            <!-- Alamat -->
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>

            <!-- Nama Barang -->
            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
            </div>

            <!-- Kuantitas -->
            <div class="form-group">
    <label for="kuantitas">Kuantitas:</label>
    <div class="input-group">
        <input type="number" 
               class="form-control" 
               id="kuantitas" 
               name="kuantitas" 
               step="0.01"    
               min="0"
               required>
        <div class="input-group-append">
            <span class="input-group-text">Kg</span> <!-- bagian step=0.01 mengizinkan angka desimal  (1) --> 
        </div>
    </div>
</div>

            

            <!-- Harga Satuan (diambil dari tabel_harga) -->
            <div class="form-group">
                <label for="harga_satuan">Harga Satuan:</label>
                <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" value="<?php echo $harga_satuan; ?>" readonly            </div>

<!-- Total Harga (readonly) -->
<div class="form-group">
    <label for="total_harga">Total Harga:</label>
    <input type="number" class="form-control" id="total_harga" name="total_harga" readonly>
</div>

<!-- Basah/Kering -->
<div class="form-group">
    <label for="basah_kering">Basah/Kering:</label>
    <select class="form-control" id="basah_kering" name="basah_kering" required>
        <option value="Basah">Basah</option>
        <option value="Kering">Kering</option>
    </select>
</div>

<!-- Keterangan -->
<div class="form-group">
    <label for="keterangan">Keterangan:</label>
    <select class="form-control" id="keterangan" name="keterangan" required>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
    </select>
</div>

<!-- Tampilkan nama penjual dalam formulir -->
<div class="form-group">
    <label for="penjual">Penjual:</label>
    <input type="text" class="form-control" id="penjual" name="penjual" value="<?php echo $penjual; ?>" readonly>
</div>

<button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
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
                    <p class="text-center mb-0">&copy; 2024 Prediksi Harga Komoditi Pertanian Jagung. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    

</body>
</html>