<?php
session_start();
require_once '../components/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['status' => 'error', 'message' => 'No data']);
    exit;
}

try {
    // Cek dulu apakah baris setting untuk user ini sudah ada?
    $check = $pdo->prepare("SELECT id FROM bot_settings WHERE user_id = ?");
    $check->execute([$user_id]);
    
    if ($check->fetch()) {
        // UPDATE yang sudah ada
        $sql = "UPDATE bot_settings SET 
                coin_category = ?, 
                strategy_type = ?, 
                target_profit = ?, 
                indicators = ?, 
                use_fundamental = ?,
                updated_at = CURRENT_TIMESTAMP
                WHERE user_id = ?";
    } else {
        // INSERT baru (Jaga-jaga kalau user langsung ke menu Pro)
        $sql = "INSERT INTO bot_settings 
                (coin_category, strategy_type, target_profit, indicators, use_fundamental, user_id)
                VALUES (?, ?, ?, ?, ?, ?)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $input['coin_category'],
        $input['strategy_type'],
        $input['target_percent'],
        json_encode($input['indicators']), // Array diubah jadi JSON String
        $input['use_fundamental'],
        $user_id
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Strategi PRO Tersimpan!']);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>