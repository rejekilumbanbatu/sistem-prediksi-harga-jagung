<?php
session_start();

// Fungsi untuk menghasilkan token admin secara acak
function generateAdminToken() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < 10; $i++) {
        $token .= $characters[mt_rand(0, $max)];
    }
    return $token;
}

// Connect to database
$servername = "localhost:3308"; // Ganti dengan hostname dan port database Anda
$db_username = "root"; // Ganti dengan username database Anda
$db_password = ""; // Ganti dengan password database Anda
$dbname = "kelompok6"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Membuat tabel admin_tokens jika belum ada
$conn->query("
    CREATE TABLE IF NOT EXISTS admin_tokens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        token VARCHAR(10) UNIQUE NOT NULL
    )
");

// Mengecek apakah token admin sudah ada di tabel, jika kurang dari 5, tambahkan token baru
$result = $conn->query("SELECT COUNT(*) AS total FROM admin_tokens");
$row = $result->fetch_assoc();
if ($row['total'] < 5) {
    $tokens_to_generate = 5 - $row['total'];
    for ($i = 0; $i < $tokens_to_generate; $i++) {
        $token = generateAdminToken();
        $conn->query("INSERT INTO admin_tokens (token) VALUES ('$token')");
    }
}

// Logout jika tombol logout diklik
if (isset($_POST['logout'])) {
    // Hapus semua data sesi
    session_unset();
    // Hancurkan sesi
    session_destroy();
    // Arahkan kembali ke halaman index
    header("Location: index.php");
    exit();
}

// Jika sudah login, arahkan ke halaman tabel.php
if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: tabel.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

// Proses registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $token = $_POST['token'];

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Periksa apakah username sudah digunakan
    $check_username_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $check_username_result = $conn->query($check_username_query);
    if ($check_username_result->num_rows > 0) {
        echo "<script>alert('Username sudah digunakan. Silakan gunakan username lain.');</script>";
        exit(); // Berhenti jika username sudah digunakan
    }

    // Jika yang didaftarkan adalah admin, periksa token admin
    if ($role == 'admin') {
        $check_token_query = "SELECT * FROM admin_tokens WHERE token='$token' LIMIT 1";
        $check_token_result = $conn->query($check_token_query);
        if ($check_token_result->num_rows == 0) {
            echo "<script>alert('Token admin tidak valid.');</script>";
            exit(); // Berhenti jika token admin tidak valid
        } else {
            // Hapus token yang digunakan
            $conn->query("DELETE FROM admin_tokens WHERE token='$token'");
        }
    }

    // Insert data pengguna ke dalam tabel users
    $sql = "INSERT INTO users (email, username, password, role) VALUES ('$email', '$username', '$hashed_password', '$role')";

    if ($conn->query($sql) === TRUE) {
        // Setelah registrasi berhasil, arahkan ke halaman sesuai dengan peran pengguna
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Register</title>
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
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Register</h3></div>
                                <div class="card-body">
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <div class="form-group">
                                            <label class="small mb-1" for="email">Email</label>
                                            <input class="form-control py-4" id="email" name="email" type="text" placeholder="Enter email" required />
                                        </div>
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
                                        <div class="form-group" id="adminToken" style="display: none;">
                                            <label class="small mb-1" for="token">Token</label>
                                            <input class="form-control py-4" id="token" name="token" type="text" placeholder="Admin Token" />
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a href="index.php" class="btn btn-secondary">Kembali</a> <!-- Tombol Kembali ke Halaman Index -->
                                            <button type="submit" class="btn btn-primary">Register</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        // Tampilkan field token admin jika peran yang dipilih adalah admin
        document.getElementById('role').addEventListener('change', function() {
            var adminTokenField = document.getElementById('adminToken');
            if (this.value === 'admin') {
                adminTokenField.style.display = 'block';
            } else {
                adminTokenField.style.display = 'none';
            }
        });
    </script>
</body>
</html>
