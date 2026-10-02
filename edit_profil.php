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
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
            text-align: center;
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

    <div class="container">
        <div class="profile-details">
            <h3>Edit Profil</h3>
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <form method="post" action="edit_profil_process.php">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="username" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap:</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="bio">Bio:</label>
                    <textarea class="form-control" id="bio" name="bio" rows="5"><?php echo htmlspecialchars($user['bio']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3"><?php echo htmlspecialchars($user['alamat']); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="profile.php" class="btn btn-default">Batal</a>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>Hak Cipta &copy; 2024 harga komoditi jagung.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        function showLogoutAlert() {
            var confirmation = confirm("Apakah Anda yakin ingin keluar?");
            if (confirmation) {
                window.location.href = "logout.php"; // Ganti 'logout.php' dengan URL logout yang benar
            }
        }
    </script>
</body>
</html>
