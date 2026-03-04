<?php
// FILE: web_dashboard/api/admin_update_strategy_settings.php
// API untuk menyimpan perubahan pada Fee Management dan Maintenance Mode.

session_start();
header('Content-Type: application/json');

// 1. Keamanan: Pastikan hanya admin yang bisa akses.
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Akses ditolak.']);
    exit;
}

require_once __DIR__ . '/../components/database.php';

// Ambil data JSON yang dikirim dari JavaScript
$input = json_decode(file_get_contents('php://input'), true);

// 2. Validasi input
if (!isset($input['admin_fee']) || !isset($input['maintenance_status'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Input tidak lengkap.']);
    exit;
}
if (!is_numeric($input['admin_fee']) || $input['admin_fee'] < 0 || $input['admin_fee'] > 100) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nilai fee harus berupa angka antara 0 dan 100.']);
    exit;
}

$admin_fee = $input['admin_fee'];
// Konversi boolean (true/false) dari JS menjadi string ('on'/'off') untuk DB
$maintenance_mode = $input['maintenance_status'] ? 'on' : 'off';

try {
    $pdo->beginTransaction();

    // 3. Gunakan 'REPLACE INTO' (atau 'INSERT OR REPLACE INTO') untuk update atau insert.
    // Ini adalah cara efisien untuk menangani setting yang mungkin sudah ada atau belum.
    $stmt = $pdo->prepare("REPLACE INTO global_settings (setting_key, setting_value) VALUES (?, ?)");
    
    // Simpan Admin Fee
    $stmt->execute(['admin_fee_percentage', $admin_fee]);
    
    // Simpan Maintenance Mode
    $stmt->execute(['maintenance_mode', $maintenance_mode]);

    $pdo->commit();

    // 4. Kirim respons sukses
    echo json_encode(['success' => true, 'message' => 'Pengaturan berhasil disimpan!']);

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'error' => 'Gagal menyimpan pengaturan ke database.',
        'details' => $e->getMessage()
    ]);
}
?>
