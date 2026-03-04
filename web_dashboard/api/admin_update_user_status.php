<?php
// FILE: web_dashboard/api/admin_update_user_status.php
// Lokasi: web_dashboard/api/admin_update_user_status.php
// Versi 1 - Path yang sudah diperbaiki berdasarkan struktur folder yang benar.

ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');

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
    
    // =================================================================
    // PERBAIKAN UTAMA: Menggunakan path yang benar dari /api/ ke /components/
    // ../components/database.php
    @require_once __DIR__ . '/../components/database.php';
    // =================================================================
    
    if (!isset($pdo)) {
        throw new Exception("Gagal memuat komponen database. Pastikan file ada di 'components/database.php'.");
    }

    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        send_json_error('Akses ditolak. Silakan login sebagai admin.', 403);
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $userId = $input['userId'] ?? null;
    $newStatus = $input['newStatus'] ?? null;

    if (!$userId || !$newStatus) {
        send_json_error('Input tidak lengkap: User ID atau status baru tidak ada.', 400);
    }

    $allowed_statuses = ['active', 'suspended'];
    if (!in_array($newStatus, $allowed_statuses)) {
        send_json_error('Status tidak valid. Hanya "active" atau "suspended" yang diizinkan.', 400);
    }
    
    $sql = "UPDATE users SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':status', $newStatus, PDO::PARAM_STR);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => "Status user ID {$userId} berhasil diubah menjadi {$newStatus}."]);
    } else {
        // Jika tidak ada baris yang terpengaruh, itu bisa karena user tidak ada ATAU statusnya sudah sama.
        // Untuk UI, lebih baik menganggap ini sukses jika tidak ada error.
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE id = :id");
        $checkStmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $checkStmt->execute();
        if ($checkStmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => "Status user ID {$userId} sudah {$newStatus}."]);
        } else {
            send_json_error("User dengan ID {$userId} tidak ditemukan.", 404);
        }
    }

} catch (Exception $e) {
    send_json_error('Terjadi kesalahan pada server.', 500, $e->getMessage());
}

restore_error_handler();
?>
