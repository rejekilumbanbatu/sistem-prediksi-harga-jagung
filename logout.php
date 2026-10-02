<?php
session_start();
// Hapus semua session
session_unset();
// Hancurkan session
session_destroy();
// Redirect ke halaman login atau halaman utama
header("Location: index.php"); // Ganti 'login.php' dengan URL yang benar
exit();
?>
