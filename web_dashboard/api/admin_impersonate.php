<?php
// FILE: web_dashboard/api/admin_impersonate.php
// VERSI 2 - Memperbaiki error "Undefined array key 'admin_id'"

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

    // Keamanan: Pastikan yang mengakses adalah admin yang sudah login.
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        send_json_error('Akses ditolak. Anda bukan admin.', 403);
    }
    
    // == PERBAIKAN: Hapus baris yang menyebabkan error ==
    // $original_admin_id = $_SESSION['admin_id']; 
    // Variabel ini tidak ada, jadi kita tidak bisa menggunakannya.

    @require_once __DIR__ . '/../components/database.php';
    if (!isset($pdo)) {
        throw new Exception("Gagal memuat komponen database.");
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $userIdToImpersonate = $input['userId'] ?? null;

    if (!$userIdToImpersonate) {
        send_json_error('User ID tidak diberikan.', 400);
    }

    $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE id = :id");
    $stmt->bindParam(':id', $userIdToImpersonate, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        send_json_error("User dengan ID {$userIdToImpersonate} tidak ditemukan.", 404);
    }
    
    // Proses Inti Impersonasi:
    // 1. Hancurkan sesi admin saat ini secara total.
    session_unset();
    session_destroy();

    // 2. Mulai sesi yang baru dan bersih.
    session_start();
    session_regenerate_id(true);

    // 3. Isi sesi baru dengan data user yang di-impersonate.
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['logged_in'] = true;

    // 4. (Opsional) Tambahkan 'flag' bahwa ini adalah sesi impersonasi.
    //    Kita tidak bisa menyimpan ID admin asli, tapi kita masih bisa menandainya.
    $_SESSION['is_impersonating'] = true;

    // Kirim respons sukses.
    echo json_encode([
        'success' => true, 
        'message' => "Impersonasi berhasil. Anda sekarang login sebagai {$user['username']}.",
        'redirectUrl' => '../index.php' // Arahkan ke dashboard user
    ]);

} catch (Exception $e) {
    send_json_error('Terjadi kesalahan pada server saat impersonasi.', 500, $e->getMessage());
}

restore_error_handler();
?>
