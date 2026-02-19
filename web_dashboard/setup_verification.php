<?php
require_once 'components/database.php';

try {
    echo "⚙️ Menambahkan Fitur Verifikasi Email...\n";

    // 1. Kolom is_verified (0 = Belum, 1 = Sudah)
    $pdo->exec("ALTER TABLE users ADD COLUMN is_verified INTEGER DEFAULT 0");
    echo "✅ Kolom 'is_verified' berhasil dibuat.\n";

    // 2. Kolom verify_token (Menyimpan kode 6 digit)
    $pdo->exec("ALTER TABLE users ADD COLUMN verify_token TEXT");
    echo "✅ Kolom 'verify_token' berhasil dibuat.\n";

} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'duplicate column') !== false) {
        echo "ℹ️ Kolom sudah ada (Aman).\n";
    } else {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
}
?>