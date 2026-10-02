<?php
session_start();

// Logout jika tombol logout diklik
if (isset($_POST['logout'])) {
    // Hapus semua data sesi
    session_unset();
    // Hancurkan sesi
    session_destroy();
    // Arahkan kembali ke halaman login
    header("Location: login.php");
    exit();
}

// Jika sudah login, arahkan ke halaman index.php
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Ambil peran dari form

    // Connect to database
    $servername = "localhost:3308";
    $db_username = "root";
    $db_password = "";
    $dbname = "kelompok6";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query SQL untuk memeriksa kredensial pengguna
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Tentukan peran pengguna berdasarkan data di database
            if ($row['role'] == 'admin' && $role == 'admin') {
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = 'admin';
                header("Location: index.php");
                exit();
            } elseif ($row['role'] == 'user' && $role == 'user') {
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = 'user';
                header("Location: index.php");
                exit();
            } else {
                $error = "Peran tidak sesuai dengan data yang ada";
            }
        } else {
            // Password salah
            $error = "Username atau password salah";
        }
    } else {
        // Pengguna tidak ditemukan
        $error = "Username atau password salah";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                <div class="card-body">
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <div class="form-group">
                                            <label class="small mb-1" for="username">Username</label>
                                            <input class="form-control py-4" id="username" name="username" type="text" placeholder="Enter username" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="password">Password</label>
                                            <input class="form-control py-4" id="password" name="password" type="password" placeholder="Enter password" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="role">Role</label>
                                            <select class="form-control" id="role" name="role" required>
                                                <option value="user">User</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                    <?php if(isset($error)): ?>
                                        <div class="alert alert-danger mt-3">
                                            <?php echo $error; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="password.html">Forgot Password?</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
