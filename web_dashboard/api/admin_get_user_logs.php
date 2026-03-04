<?php
// FILE: web_dashboard/api/admin_get_user_logs.php
// API ini bertugas mengambil semua catatan log untuk satu user tertentu.

// FILE: web_dashboard/api/admin_get_user_logs.php
// ... (deskripsi file)

// Keamanan Terpusat: Memeriksa sesi admin.
require_once __DIR__ . '/admin_auth_check.php';

// Atur header JSON setelah pengecekan keamanan berhasil.
header('Content-Type: application/json');

// Muat koneksi database
require_once __DIR__ . '/../components/database.php';

// ... sisa kode tidak berubah ...


// Muat koneksi database
require_once __DIR__ . '/../components/database.php';

// Ambil User ID dari parameter GET
$user_id = $_GET['user_id'] ?? null;

// Validasi: Pastikan user_id ada dan merupakan angka
if (!$user_id || !filter_var($user_id, FILTER_VALIDATE_INT)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'User ID tidak valid atau tidak disediakan.']);
    exit;
}

try {
    // Ambil data user untuk ditampilkan di header modal
    $userStmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
    $userStmt->execute([$user_id]);
    $user = $userStmt->fetch();

    if (!$user) {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'User tidak ditemukan.']);
        exit;
    }

    // Ambil semua log untuk user tersebut, diurutkan dari yang paling baru
    $logStmt = $pdo->prepare(
        "SELECT timestamp, action, ip_address, details 
         FROM user_logs 
         WHERE user_id = ? 
         ORDER BY timestamp DESC"
    );
    $logStmt->execute([$user_id]);
    $logs = $logStmt->fetchAll(PDO::FETCH_ASSOC);

    // Kirim respons sukses dengan data user dan log-nya
    echo json_encode([
        'success' => true,
        'user' => [
            'username' => $user['username'],
            'email' => $user['email']
        ],
        'logs' => $logs
    ]);

} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    // KIRIM PESAN ERROR SPESIFIK UNTUK DEBUGGING
    echo json_encode([
        'error' => 'Query database gagal.',
        'detail' => $e->getMessage() // Ini akan menampilkan pesan error asli dari PDO
    ]);
    // error_log("API Error (admin_get_user_logs): " . $e->getMessage());
}

?>
