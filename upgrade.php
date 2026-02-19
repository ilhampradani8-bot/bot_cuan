<?php
// upgrade.php
try {
    // Buka Database
    $pdo = new PDO("sqlite:bot_cuan.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Daftar Kolom Baru yang Dibutuhkan Rust
    $commands = [
        "ALTER TABLE alerts ADD COLUMN mode TEXT DEFAULT 'easy'",
        "ALTER TABLE alerts ADD COLUMN category TEXT DEFAULT 'MANUAL'",
        "ALTER TABLE alerts ADD COLUMN strategy TEXT DEFAULT 'simple'",
        "ALTER TABLE alerts ADD COLUMN indicators TEXT DEFAULT '[]'",
        "ALTER TABLE alerts ADD COLUMN fundamental_active INTEGER DEFAULT 0"
    ];

    echo "⚙️ Memulai Upgrade Database...\n";

    foreach ($commands as $sql) {
        try {
            $pdo->exec($sql);
            echo "✅ Berhasil: " . substr($sql, 0, 30) . "...\n";
        } catch (Exception $e) {
            // Kalau error "duplicate column", berarti sudah ada (Aman)
            echo "ℹ️ Skip (Sudah ada): " . substr($sql, 0, 30) . "...\n";
        }
    }
    
    echo "\n🎉 DATABASE SIAP! Silakan jalankan cargo run lagi.\n";

} catch (Exception $e) {
    echo "❌ Error Fatal: " . $e->getMessage() . "\n";
}
?>
