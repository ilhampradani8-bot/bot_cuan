<?php
// FILE: web_dashboard/api/admin_get_strategy_data.php
// API untuk mengambil data PnL global, fee, dan status maintenance.

session_start();
header('Content-Type: application/json');

// 1. Keamanan: Pastikan hanya admin yang login yang bisa akses.
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo json_encode(['error' => 'Akses ditolak. Anda bukan admin.']);
    exit;
}

require_once __DIR__ . '/../components/database.php';

// Helper function untuk mengambil setting dari database
function get_setting($pdo, $key, $default_value = null) {
    $stmt = $pdo->prepare("SELECT setting_value FROM global_settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $value = $stmt->fetchColumn();
    return $value !== false ? $value : $default_value;
}

try {
    // 2. Kalkulasi Global PnL (Profit and Loss)
    // TODO: Ganti ini dengan query sesungguhnya ke tabel trade/log Anda.
    // Ini adalah placeholder.
    // Contoh query: "SELECT SUM(profit_amount) FROM trade_history WHERE status = 'closed'"
    $global_pnl = 78500000; // Placeholder: 78.5 Juta

    // 3. Ambil Pengaturan dari Database
    $admin_fee = get_setting($pdo, 'admin_fee_percentage', '5'); // Default 5%
    $maintenance_mode = get_setting($pdo, 'maintenance_mode', 'off'); // Default 'off'

    // 4. Siapkan data untuk dikirim sebagai JSON
    $response_data = [
        'success' => true,
        'global_pnl' => $global_pnl,
        'global_pnl_formatted' => 'Rp ' . number_format($global_pnl, 0, ',', '.'),
        'admin_fee_percentage' => floatval($admin_fee),
        'maintenance_mode_status' => $maintenance_mode === 'on' ? true : false,
    ];

    echo json_encode($response_data);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database Error', 
        'details' => $e->getMessage()
    ]);
}

?>
