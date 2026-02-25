<?php
// File: web_dashboard/api/market_scanner.php
// Versi ini dirancang untuk menangkap error dan melaporkannya dengan benar.

header('Content-Type: application/json');

// Fungsi untuk memastikan kita selalu mengirim response JSON yang valid, bahkan saat error.
function send_json_error($message, $http_code = 500, $details = null) {
    http_response_code($http_code);
    $response = ['status' => 'error', 'message' => $message];
    if ($details) {
        // Memberikan detail error teknis untuk debugging
        $response['error_details'] = $details;
    }
    echo json_encode($response);
    exit; // Menghentikan eksekusi skrip setelah mengirim error.
}

// Langkah 1: Mencoba memuat file koneksi database.
// Tanda @ digunakan untuk menekan warning standar agar kita bisa tangani sendiri.
@require_once __DIR__ . '/../components/database.php';

// Langkah 2: Memeriksa apakah objek koneksi database ($pdo) berhasil dibuat.
// Jika file database.php gagal (misal: password salah), variabel $pdo tidak akan ada.
if (!isset($pdo) || !$pdo instanceof PDO) {
    send_json_error('Koneksi ke database gagal. Periksa file komponen/database.php.');
}

// Langkah 3: Mencoba menjalankan query ke database.
try {
    // Query ini mengambil data dari tabel 'market_data'.
    $stmt = $pdo->query("SELECT `pair`, `close`, `volume` FROM `market_data` ORDER BY `pair` ASC");

    // Memeriksa apakah query berhasil dieksekusi.
    if ($stmt === false) {
        // Ini paling sering terjadi jika tabel 'market_data' tidak ditemukan.
        $errorInfo = $pdo->errorInfo();
        send_json_error('Eksekusi query gagal. Kemungkinan tabel `market_data` tidak ada.', 500, $errorInfo[2]);
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Jika semua berhasil, kirim data.
    echo json_encode([
        'status' => 'success',
        'data'   => $results
    ]);

} catch (PDOException $e) {
    // Menangkap error lain yang mungkin terjadi selama interaksi dengan database.
    send_json_error('Terjadi pengecualian pada database.', 500, $e->getMessage());
}
?>
