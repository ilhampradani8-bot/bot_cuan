<?php
// FILE: web_dashboard/api/admin_auth_check.php
// File ini akan menjadi satu-satunya sumber kebenaran untuk memeriksa otentikasi admin di semua API.

// Selalu mulai sesi di awal
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah sesi admin yang valid ada
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Jika tidak, kirim respons error 403 (Forbidden) dalam format JSON dan hentikan eksekusi.
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Akses ditolak. Sesi admin tidak valid.']);
    exit;
}

// Jika lolos, skrip yang memanggil file ini bisa melanjutkan.
?>
