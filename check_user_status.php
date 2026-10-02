<?php
session_start();
// Contoh: cek status admin dari sesi
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

echo json_encode(['isAdmin' => $isAdmin]);
?>
    