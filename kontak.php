<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontak - Prediksi Harga Komoditi Jagung</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/lux/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f3f3f3;
        }

        .contact-header {
            text-align: center;
            padding: 40px 0;
            background-color: #1b7c81;
            color: #fff;
        }

        .contact-header h1 {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .contact-header p {
            font-size: 20px;
            color: #d4d4d4;
        }

        .contact-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin: 30px 0;
        }

        .contact-section {
            flex: 0 1 45%;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .contact-section h3 {
            font-size: 30px;
            margin-bottom: 20px;
            color: #1b7c81;
        }

        .contact-list {
            list-style: none;
            padding: 0;
        }

        .contact-list li {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }

        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .footer h5 {
            color: #ffffff;
        }

        .footer p {
            color: #ffffff;
            margin-bottom: 10px;
        }

        .footer ul li a {
            color: #ffffff;
        }

        .footer ul li a:hover {
            color: #cccccc;
        }

        .footer p.mb-0 {
            margin-bottom: 0; 
        }

        .navbar-brand img {
            height: 24px;
            margin-right: 5px;
        }

        .contact-section .list {
            flex: 1 1 300px;
            margin: 20px;
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .contact-section .list:hover {
            transform: translateY(-10px);
        }

        .contact-section .list img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            margin-bottom: 15px;
            border: 5px solid #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
                    <li class="nav-item active">
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

    <!-- Contact Header -->
    <div class="contact-header">
        <div class="container">
            <h1>Kontak Kami</h1>
            <p>Hubungi kami melalui informasi di bawah ini.</p>
        </div>
    </div>

    <!-- Contact Content -->
    <div class="container">
        <div class="contact-content">
            <div class="contact-section">
                <h3>Kontak Developer</h3>
                <div class="list">
                    <img src="img/developer1.jpg" alt="Janter Hugo Purba">
                    <ul class="contact-list">
                        <li><strong>Nama:</strong> Janter Hugo Purba</li>
                        <li><strong>Email:</strong> janterhugopurba@gmail.com</li>
                        <li><strong>Telepon:</strong> +62 812-3456-7890</li>
                    </ul>
                </div>
                <div class="list">
                    <img src="img/developer2.jpg" alt="Rejeki Adi Putra Lumban Batu">
                    <ul class="contact-list">
                        <li><strong>Nama:</strong> Rejeki Adi Putra Lumban Batu</li>
                        <li><strong>Email:</strong> rejekiadiputra@gmail.com</li>
                        <li><strong>Telepon:</strong> +62 812-3456-7890</li>
                    </ul>
                </div>
                <div class="list">
                    <img src="img/developer3.jpg" alt="Dealova Zevanya Manurung">
                    <ul class="contact-list">
                        <li><strong>Nama:</strong> Dealova Zevanya Manurung</li>
                        <li><strong>Email:</strong> dealovazevanyamanurung@gmail.com</li>
                        <li><strong>Telepon:</strong> +62 812-3456-7890</li>
                    </ul>
                </div>
            </div>
            <div class="contact-section">
                <h3>Kontak Admin/Toke</h3>
                <div class="list">
                    <img src="img/admin1.jpg" alt="Admin/Toke 1">
                    <ul class="contact-list">
                        <li><strong>Nama:</strong> Admin/Toke 1</li>
                        <li><strong>Email:</strong> admin1@example.com</li>
                        <li><strong>Telepon:</strong> +62 812-1234-5678</li>
                    </ul>
                </div>
                <div class="list">
                    <img src="img/admin2.jpg" alt="Admin/Toke 2">
                    <ul class="contact-list">
                        <li><strong>Nama:</strong> Admin/Toke 2</li>
                        <li><strong>Email:</strong> admin2@example.com</li>
                        <li><strong>Telepon:</strong> +62 812-9876-5432</li>
                    </ul>
                </div>
                <div class="list">
                    <img src="img/admin3.jpg" alt="Admin/Toke 3">
                    <ul class="contact-list">
                        <li><strong>Nama:</strong> Admin/Toke 3</li>
                        <li><strong>Email:</strong> admin3@example.com</li>
                        <li><strong>Telepon:</strong> +62 812-4567-8901</li>
                    </ul>
                </div>
            </div>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
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
