<?php
// FILE: web_dashboard/api/market_scanner.php
header('Content-Type: application/json');
$db_path = '/home/ilham/projects/bot_cuan/market_data.db';

try {
    $pdo = new PDO("sqlite:$db_path");
    // Ambil data terbaru (terakhir diinput) untuk setiap pair
    $sql = "SELECT pair, close as price, volume FROM candles_1m 
            WHERE id IN (SELECT MAX(id) FROM candles_1m GROUP BY pair)";
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $data]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>