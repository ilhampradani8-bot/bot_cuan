<?php
// FILE: web_dashboard/setup_market_db.php

// Kita taruh file DB ini SEJAJAR dengan bot_cuan.db (di luar folder web_dashboard)
$db_path = __DIR__ . '/../market_data.db'; 

try {
    // 1. Buat Koneksi ke File Baru
    $pdo_market = new PDO("sqlite:$db_path");
    $pdo_market->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Buat Tabel Candles (Khusus Data Grafik)
    // Kita simpan timeframe 1 menit (1m)
    // Struktur: Pair, Waktu, O-H-L-C, Volume
    $sql = "CREATE TABLE IF NOT EXISTS candles_1m (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pair TEXT NOT NULL,       -- Contoh: 'BTC/IDR'
        time INTEGER NOT NULL,    -- Unix Timestamp (misal: 1708260000)
        open REAL NOT NULL,
        high REAL NOT NULL,
        low REAL NOT NULL,
        close REAL NOT NULL,
        volume REAL,
        UNIQUE(pair, time)        -- Mencegah data ganda di menit yang sama
    )";
    
    $pdo_market->exec($sql);
    
    echo "<h1>✅ SUKSES!</h1>";
    echo "<p>Database Market berhasil dibuat di: <b>$db_path</b></p>";
    echo "<p>Tabel <code>candles_1m</code> siap menampung data.</p>";

} catch (PDOException $e) {
    echo "<h1>❌ GAGAL</h1>";
    echo "Error: " . $e->getMessage();
}
?>