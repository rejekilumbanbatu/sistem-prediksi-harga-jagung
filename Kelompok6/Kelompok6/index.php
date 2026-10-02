    <?php
    session_start();

    $servername = "localhost:3308";
    $username = "root";
    $password = "";
    $dbname = "kelompok6";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
    $user_name = isset($_SESSION['username']) ? $_SESSION['username'] : '';

    $sql = "SELECT * FROM tabel_harga ORDER BY Tanggal DESC LIMIT 1";
    $result = $conn->query($sql);

    $data_harga = array();
    if ($result->num_rows > 0) {
        $data_harga = $result->fetch_assoc();
        $harga_balige = $data_harga['Harga'] * 0.85;
        $harga_sitoluama = $data_harga['Harga'] * 0.87;
        $harga_porsea = $data_harga['Harga'] * 0.89;
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
            /* CSS baru untuk tombol grafik */
    .graph-button {
        border-radius: 30px; /* Membuat tombol lebih bulat */
        padding: 15px 30px; /* Memberi ruang di dalam tombol */
        font-weight: bold; /* Membuat teks lebih tebal */
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.3); /* Memberikan efek bayangan */
        transition: all 0.3s ease; /* Efek transisi untuk hover */
    }

    .graph-button:hover {
        transform: translateY(-2px); /* Mendorong tombol sedikit ke atas saat dihover */
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.5); /* Meningkatkan intensitas bayangan saat dihover */
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
    <!-- Content -->
    <section class="content">
            <div class="container">
                <h2 class="text-center">Harga Terbaru</h2><br><b><hr></b>
                <div class="thumbnails-container row">
                <div class="col-md-4">
                    <div class="thumbnail" data-harga="<?php echo $harga_balige; ?>" data-daerah="Balige">
                        <img src="./img/balige.jpeg" alt="Balige">
                        <div class="caption">
                            <h3>Balige</h3>
                            <p>Harga pada tanggal (<?php echo $data_harga['tanggal']; ?>): Rp <?php echo number_format($harga_balige, 2, ',', '.'); ?></p>
                            <p>Dijemput ditempat: Rp <?php echo number_format($harga_balige * 0.92, 2, ',', '.'); ?> (kurangi 8% dari harga)</p>
                            <p>Diantar ke tempat: Rp <?php echo number_format($harga_balige, 2, ',', '.'); ?></p>
                            <p><a href="javascript:void(0);" class="btn btn-default btn-read-more" role="button" onclick="return checkLogin();">Jual Jagung</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumbnail" data-harga="<?php echo $harga_sitoluama; ?>" data-daerah="Sitoluama">
                        <img src="./img/sitoluama.jpg" alt="Sitoluama">
                        <div class="caption">
                            <h3>Sitoluama</h3>
                            <p>Harga pada tanggal (<?php echo $data_harga['tanggal']; ?>): Rp <?php echo number_format($harga_sitoluama, 2, ',', '.'); ?></p>
                            <p>Dijemput ditempat: Rp <?php echo number_format($harga_sitoluama * 0.91, 2, ',', '.'); ?> (kurangi 9% dari harga)</p>
                            <p>Diantar ke tempat: Rp <?php echo number_format($harga_sitoluama, 2, ',', '.'); ?></p>
                            <p><a href="javascript:void(0);" class="btn btn-default btn-read-more" role="button" onclick="return checkLogin();">Jual Jagung</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumbnail" data-harga="<?php echo $harga_porsea; ?>" data-daerah="Porsea">
                        <img src="./img/porsea.jpg" alt="Porsea">
                        <div class="caption">
                            <h3>Porsea</h3>
                            <p>Harga pada tanggal (<?php echo $data_harga['tanggal']; ?>): Rp <?php echo number_format($harga_porsea, 2, ',', '.'); ?></p>
                            <p>Dijemput ditempat: Rp <?php echo number_format($harga_porsea * 0.90, 2, ',', '.'); ?> (kurangi 10% dari harga)</p>
                            <p>Diantar ke tempat: Rp <?php echo number_format($harga_porsea, 2, ',', '.'); ?></p>
                            <p><a href="javascript:void(0);" class="btn btn-default btn-read-more" role="button" onclick="return checkLogin();">Jual Jagung</a></p>
                        </div>
                    </div>
                </div>
            </div>
                </div>
                <!-- Text above graph button -->
                <div class="text-center mt-4">
                    <p>Informasi grafik penjualan jagung dapat membantu Anda dalam analisis lebih lanjut.</p>
                </div>
                <!-- Graph Button -->
                <div class="text-center mt-4">
                    <a href="grafikpenjualan.php" class="btn btn-primary btn-lg mx-auto graph-button">Lihat Grafik Penjualan</a>
                </div>

            </div>
        </section>
        


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function checkLogin() {
            <?php if (!isset($_SESSION['username']) || $_SESSION['role'] === 'admin'): ?>
                alert("Anda harus login sebagai user untuk menjual jagung.");
                // Prevent default action by returning false
                return false;
            <?php else: ?>
                // Allow the redirection
                window.location.href = "form_penjualan.php";
                return true;
            <?php endif; ?>
        }
        </script>
        <script>
            function showLogoutAlert() {
                var confirmation = confirm("Apakah Anda yakin ingin keluar?");
                if (confirmation) {
                    window.location.href = "logout.php"; // Ganti 'logout.php' dengan URL logout yang benar
                }
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $('.thumbnail').click(function() {
                    var hargaSatuan = $(this).data('Harga');
                    var daerah = $(this).data('daerah');
                    window.location.href = "form_penjualan.php?harga=" + hargaSatuan + "&daerah=" + daerah;
                });
            });
            
        </script>
    <script>
        $(document).ready(function() {
            $('.thumbnail').click(function() {
                var hargaSatuan = $(this).data('Harga');
                var daerah = $(this).data('daerah');
                window.location.href = "form_penjualan.php?harga=" + hargaSatuan + "&daerah=" + daerah;
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
                        <p class="text-center mb-0">&copy; 2024 Prediksi Harga Komoditi Pertanian Jagung. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>


    </body>
    </html>