<?php
session_start();
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
    background-color: #f3f3f3; /* Updated background color */
}

.about-header {
    text-align: center;
    padding: 50px 0;
    background-color: #1b7c81; /* Updated background color */
    color: #fff; /* Updated text color */
}

.about-header h1 {
    font-size: 48px; /* Increased font size */
    font-weight: bold;
    margin-bottom: 20px;
}

.about-header p {
    font-size: 20px; /* Increased font size */
    color: #d4d4d4; /* Updated text color */
}
/* CSS for centering .header */
.header {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    height: 29vh; 
    background-color: #1b7c81; /* Background color */
    color: #fff; /* Text color */
}

.header h1 {
    font-size: 30px;
    font-weight: bold;
    margin-top: 8px;
}

.header p {
    font-size: 20px;
    color: #d4d4d4;
}


.about-content {
    padding: 30px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    border-radius: 10px; /* Added border radius */
}

.about-section h3 {
    font-size: 30px; /* Increased font size */
    margin-bottom: 20px;
    color: #1b7c81; /* Updated text color */
}

.about-section p {
    font-size: 18px; /* Increased font size */
    margin-bottom: 10px;
    color: #333; /* Updated text color */
}

.team-member h3 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #1b7c81; /* Updated text color */
}

.team-member p {
    font-size: 16px;
    color: #555;
}

.footer {
    background-color: #1b7c81; /* Updated background color */
    color: #fff;
    padding-top: 30px;
    padding-bottom: 30px;
}

.footer h5 {
    color: #fff; /* Updated text color */
}

.footer p {
    color: #fff; /* Updated text color */
    margin-bottom: 10px;
}

.footer ul li a {
    color: #fff; /* Updated text color */
}

.footer ul li a:hover {
    color: #ccc; /* Updated hover color */
}

.footer p.mb-0 {
    margin-bottom: 0; 
}
    .container .h1{
        color: black;
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
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .team-member:hover {
            transform: translateY(-10px);
        }

        .team-member img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            margin-bottom: 15px;
            border: 5px solid #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .team-member h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #343a40;
        }

        .team-member p {
            font-size: 16px;
            color: #555;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .navbar-brand img {
            height: 24px;
            margin-right: 5px;
        }
        .about-section {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .about-section.active {
        opacity: 1;
        transform: translateY(0);
    }

    .about-header {
        position: relative;
        overflow: hidden;
    }

    .about-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, #f8f9fa, #e9ecef, #f8f9fa);
        animation: gradient 15s linear infinite;
    }

    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
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
                    <li class="nav-item active">
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
                            <div class="dropdown-menu dropdown-menu-right">                                <a class="dropdown-item" href="profile.php">Profile</a>
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

       <div class="header">
            <h1>Tentang Kami</h1>
            <p>Informasi tentang tim dan visi misi kami.</p>
        </div>
    <div class="container">
        <h2>Visi dan Misi</h2> <!-- Tambahkan judul Visi dan Misi -->
        <div class="about-content">
            <div class="about-section">
                <h3>Visi Kami</h3>
                <p>Menjadi platform terdepan dalam memberikan prediksi harga komoditi jagung yang akurat dan terpercaya, membantu petani dan pelaku industri untuk membuat keputusan yang tepat dan strategis.</p>
            </div>
            <div class="about-section">
                <h3>Misi Kami</h3>
                <p>1. Mengembangkan algoritma prediksi yang inovatif dan akurat.</p>
                <p>2. Memberikan informasi yang dapat diandalkan kepada pengguna kami.</p>
                <p>3. Membangun komunitas yang aktif dan saling mendukung di antara petani dan pelaku industri.</p>
                <p>4. Meningkatkan kesejahteraan petani melalui informasi yang tepat waktu dan strategis.</p>
            </div>
        </div>

        <div class="about-section">
            <h3>Tim Kami</h3>
            <div class="team">
                <div class="team-member">
                    <img src="./img/janter.jpg" alt="Member 1">
                    <h3>Janter Hugo Purba</h3>
                    <p>Project Manager</p>
                </div>
                <div class="team-member">
                    <img src="./img/rejeki.jpg" alt="Member 2">
                    <h3>Rejeki Adi Putra Lumban Batu</h3>
                    <p>Anggota</p>
                </div>
                <div class="team-member">
                    <img src="./img/dealova.jpg" alt="Member 3">
                    <h3>Dealova Zevanya Manurung</h3>
                    <p>Anggota</p>
                </div>
            </div>
        </div>
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

        // Tambahkan class 'active' ke setiap bagian saat scrolling
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('scroll', function() {
                var aboutSections = document.querySelectorAll('.about-section');
                aboutSections.forEach(function(section) {
                    if (isElementInViewport(section)) {
                        section.classList.add('active');
                    }
                });
            });
        });

        // Fungsi untuk memeriksa apakah suatu elemen terlihat di dalam viewport
        function isElementInViewport(el) {
            var rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }
    </script>
</body>
</html>

                               
