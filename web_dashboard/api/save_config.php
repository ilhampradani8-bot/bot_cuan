<?php
session_start();
require_once '../components/database.php';

header('Content-Type: application/json');

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Login required']);
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. Ambil Data dari JSON (Fetch API)
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
    exit;
}

try {
    // 3. Cek Status Premium User
    // Kita harus validasi lagi di sini, jangan cuma percaya tampilan UI
    $stmtUser = $pdo->prepare("SELECT expired_at FROM users WHERE id = ?");
    $stmtUser->execute([$user_id]);
    $u = $stmtUser->fetch();
    
    $is_premium = false;
    if ($u['expired_at']) {
        if (new DateTime($u['expired_at']) > new DateTime()) {
            $is_premium = true;
        }
    }

    // Jika user TIDAK Premium, paksa is_active jadi 0 (Mati)
    // Jadi walaupun dia hack frontend biar tombol nyala, backend tetap menolak menyalakan bot.
    $is_active = $is_premium ? ($input['is_active'] ?? 0) : 0;

    // 4. Simpan / Update Setting
    // Kita pakai "INSERT OR REPLACE" atau logika Check-Insert-Update
    
    // Cek dulu udah ada belum settingannya
    $check = $pdo->prepare("SELECT id FROM bot_settings WHERE user_id = ?");
    $check->execute([$user_id]);
    $exists = $check->fetch();

    if ($exists) {
        // UPDATE
        $sql = "UPDATE bot_settings SET 
                api_key = ?, secret_key = ?, pair = ?, 
                target_profit = ?, stop_loss = ?, is_active = ?, updated_at = CURRENT_TIMESTAMP
                WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $input['api_key'], 
            $input['secret_key'], 
            strtoupper($input['pair']), 
            $input['target_profit'], 
            $input['stop_loss'], 
            $is_active, 
            $user_id
        ]);
    } else {
        // INSERT BARU
        $sql = "INSERT INTO bot_settings (user_id, api_key, secret_key, pair, target_profit, stop_loss, is_active)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $user_id,
            $input['api_key'], 
            $input['secret_key'], 
            strtoupper($input['pair']), 
            $input['target_profit'], 
            $input['stop_loss'], 
            $is_active
        ]);
    }

    echo json_encode(['status' => 'success', 'message' => 'Konfigurasi tersimpan!']);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>