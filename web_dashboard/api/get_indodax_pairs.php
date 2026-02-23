<?php
// FILE: web_dashboard/api/get_indodax_pairs.php
// [PHP LOGIC] Backend proxy untuk bypass CORS Indodax
header('Content-Type: application/json');

$url = 'https://indodax.com/api/tickers';

// Mengambil data server-to-server (Aman dari CORS browser)
$response = @file_get_contents($url);

if ($response !== false) {
    $data = json_decode($response, true);
    $pairs = [];
    
    // Looping untuk merapikan data agar siap pakai di frontend
    foreach ($data['tickers'] as $id => $ticker) {
        $pairs[] = [
            'id' => $id, // Contoh: btc_idr
            'name' => strtoupper(str_replace('_', '/', $id)) // Contoh: BTC/IDR
        ];
    }
    
    echo json_encode(['status' => 'success', 'data' => $pairs]);
} else {
    // Jika API Indodax sedang gangguan, kita kasih fallback list (cadangan)
    $fallback = [
        ['id' => 'btc_idr', 'name' => 'BTC/IDR'],
        ['id' => 'eth_idr', 'name' => 'ETH/IDR'],
        ['id' => 'doge_idr', 'name' => 'DOGE/IDR'],
        ['id' => 'sol_idr', 'name' => 'SOL/IDR']
    ];
    echo json_encode(['status' => 'fallback', 'data' => $fallback]);
}
?>