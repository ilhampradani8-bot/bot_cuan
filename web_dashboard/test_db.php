<?php
// web_dashboard/test_db.php
require_once 'components/database.php';

echo "<h2>🧪 Testing Database Connection</h2>";

try {
    // 1. Coba Input Data Tes
    $test_wa = "089988776655";
    $test_price = 1200000000;
    
    $sql = "INSERT INTO alerts (phone_number, coin_pair, target_price, status) 
            VALUES (:wa, 'btc_idr', :price, 'ACTIVE')";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':wa' => $test_wa, ':price' => $test_price]);
    
    echo "✅ Berhasil INSERT data tes ke SQLite!<br>";

    // 2. Cek Apakah Data Muncul
    $query = $pdo->query("SELECT * FROM alerts ORDER BY id DESC LIMIT 5");
    $rows = $query->fetchAll();

    echo "<h3>Daftar 5 Alert Terakhir:</h3>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>
            <tr><th>ID</th><th>WA</th><th>Koin</th><th>Target Harga</th></tr>";
    
    foreach ($rows as $row) {
        echo "<tr>
                <td>{$row->id}</td>
                <td>{$row->phone_number}</td>
                <td>{$row->coin_pair}</td>
                <td>Rp " . number_format($row->target_price, 0, ',', '.') . "</td>
              </tr>";
    }
    echo "</table>";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);