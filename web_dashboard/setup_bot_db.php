<?php
require_once 'components/database.php';

try {
    // Hapus tabel lama kalau ada (biar fresh)
    $pdo->exec("DROP TABLE IF EXISTS bot_settings");

    // Buat tabel BARU
    $sql = "CREATE TABLE bot_settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL UNIQUE,
        api_key TEXT,
        secret_key TEXT,
        pair TEXT DEFAULT 'BTC/IDR',
        target_profit REAL DEFAULT 1.5,
        stop_loss REAL DEFAULT 2.0,
        amount_percent INTEGER DEFAULT 100, -- Pakai berapa % saldo
        is_active INTEGER DEFAULT 0, -- 0 = Mati, 1 = Jalan
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "✅ SUKSES! Tabel 'bot_settings' berhasil dibuat ulang.";
} catch (PDOException $e) {
    echo "❌ Gagal: " . $e->getMessage();
}
?>