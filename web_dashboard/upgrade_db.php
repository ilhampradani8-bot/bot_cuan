<?php
// upgrade_db.php
require_once 'components/database.php';

try {
    // Tambah kolom-kolom baru untuk fitur PRO
    $cols = [
        "ALTER TABLE alerts ADD COLUMN mode TEXT DEFAULT 'easy'", 
        "ALTER TABLE alerts ADD COLUMN category TEXT DEFAULT 'MANUAL'",
        "ALTER TABLE alerts ADD COLUMN strategy TEXT DEFAULT 'simple'",
        "ALTER TABLE alerts ADD COLUMN indicators TEXT DEFAULT '[]'",
        "ALTER TABLE alerts ADD COLUMN fundamental_active INTEGER DEFAULT 0"
    ];

    foreach ($cols as $sql) {
        try {
            $pdo->exec($sql);
            echo "✅ Berhasil tambah kolom baru.<br>";
        } catch (Exception $e) {
            // Kalau kolom sudah ada, dia bakal error (abaikan saja)
            echo "ℹ️ Kolom mungkin sudah ada (Skip).<br>";
        }
    }
    echo "<h1>🎉 DATABASE SUDAH SIAP UNTUK MODE PRO!</h1>";
    echo "<a href='pro.php'>Kembali ke Cockpit Pro</a>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}