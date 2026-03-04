<?php
// FILE: web_dashboard/api/admin_update_user_expiry.php
// API untuk memperbarui tanggal kedaluwarsa (expiry date) seorang user.

ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Fungsi helper dari file sebelumnya untuk konsistensi
function send_json_error($message, $http_code = 500, $details = null) {
    http_response_code($http_code);
    $response = ['success' => false, 'error' => $message];
    if ($details) {
        $response['details'] = $details;
    }
    echo json_encode($response);
    exit;
}

set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

try {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Path yang sudah kita pastikan benar
    @require_once __DIR__ . '/../components/database.php';
    
    if (!isset($pdo)) {
        throw new Exception("Gagal memuat komponen database.");
    }

    // Hanya admin yang boleh mengakses
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        send_json_error('Akses ditolak. Silakan login sebagai admin.', 403);
    }

    // Ambil dan validasi input dari request
    $input = json_decode(file_get_contents('php://input'), true);
    $userId = $input['userId'] ?? null;
    $newExpiryDate = $input['newExpiryDate'] ?? null;

    if (!$userId || !$newExpiryDate) {
        send_json_error('Input tidak lengkap: User ID atau tanggal baru tidak ada.', 400);
    }
    
    // Validasi format tanggal (YYYY-MM-DD)
    $d = DateTime::createFromFormat('Y-m-d', $newExpiryDate);
    if (!$d || $d->format('Y-m-d') !== $newExpiryDate) {
        send_json_error('Format tanggal tidak valid. Gunakan format YYYY-MM-DD.', 400);
    }

    // Lakukan update pada database
    $sql = "UPDATE users SET expired_at = :expired_at WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':expired_at', $newExpiryDate, PDO::PARAM_STR);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => "Tanggal kedaluwarsa user ID {$userId} berhasil diubah menjadi {$newExpiryDate}."]);
    } else {
        // Cek apakah user memang ada, untuk memberikan pesan error yang lebih baik
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE id = :id");
        $checkStmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $checkStmt->execute();
        if ($checkStmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => "User ID {$userId} sudah memiliki tanggal kedaluwarsa {$newExpiryDate}."]);
        } else {
            send_json_error("User dengan ID {$userId} tidak ditemukan.", 404);
        }
    }

} catch (Exception $e) {
    send_json_error('Terjadi kesalahan pada server.', 500, $e->getMessage());
}

restore_error_handler();
?>
