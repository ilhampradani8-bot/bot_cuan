<?php
// FILE: web_dashboard/api/chart_data.php
error_reporting(0);
header('Content-Type: application/json');

try {
    // 1. PASTIKAN PATH DATABASE BENAR (Gunakan yang dari setup tadi)
    $db_path = '/home/ilham/projects/bot_cuan/market_data.db'; 

    if (!file_exists($db_path)) {
        throw new Exception("File Database tidak ditemukan di path: $db_path");
    }

    $pdo = new PDO("sqlite:$db_path");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 2. AMBIL PAIR (Default BTC_IDR)
    $pair = $_GET['pair'] ?? 'btc_idr';
    // Kita buat case-insensitive agar mau BTC_IDR atau btc_idr tetap ketemu
    $pair_upper = strtoupper(str_replace('_', '/', $pair)); // Jadi BTC/IDR
    $pair_lower = strtolower(str_replace('/', '_', $pair)); // Jadi btc_idr

    // 3. QUERY DATA ASLI
    // Kita cari yang match dengan format di DB Mas (biasanya btc_idr)
    $stmt = $pdo->prepare("SELECT time, open, high, low, close FROM candles_1m WHERE pair = ? OR pair = ? ORDER BY time ASC LIMIT 500");
    $stmt->execute([$pair_lower, $pair_upper]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $final_data = [];
    foreach($results as $row) {
        $final_data[] = [
            'time'  => (int)$row['time'],
            'open'  => (float)$row['open'],
            'high'  => (float)$row['high'],
            'low'   => (float)$row['low'],
            'close' => (float)$row['close']
        ];
    }

    echo json_encode([
        'status' => 'success', 
        'source' => 'DATABASE_REAL',
        'count'  => count($final_data),
        'data'   => $final_data
    ]);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>