<?php
// File: web_dashboard/setup_user_management.php
// Menambah kolom dan tabel yang dibutuhkan untuk manajemen user dan transaksi.

require_once 'components/database.php';

echo "Memulai proses setup...<br><br>";

try {
    // 1. Add 'status' column to manage user account state (active, suspended, banned)
    $pdo->exec("ALTER TABLE users ADD COLUMN status TEXT NOT NULL DEFAULT 'active'");
    echo "✅ Kolom 'status' berhasil ditambahkan ke tabel users.<br>";
} catch (Exception $e) {
    echo "ℹ️ Kolom 'status' mungkin sudah ada. Pesan: " . $e->getMessage() . "<br>";
}

try {
    // 2. Add 'last_login' column to track user activity
    $pdo->exec("ALTER TABLE users ADD COLUMN last_login DATETIME DEFAULT NULL");
    echo "✅ Kolom 'last_login' berhasil ditambahkan ke tabel users.<br>";
} catch (Exception $e) {
    echo "ℹ️ Kolom 'last_login' mungkin sudah ada. Pesan: " . $e->getMessage() . "<br>";
}

try {
    // 3. Create 'transactions' table to log subscription payments
    $sql = "
    CREATE TABLE IF NOT EXISTS transactions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        proof_file TEXT NOT NULL,
        status TEXT NOT NULL DEFAULT 'pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users (id)
    );
    ";
    $pdo->exec($sql);
    echo "✅ Tabel 'transactions' berhasil dibuat atau sudah ada.<br>";

} catch (Exception $e) {
    echo "❌ GAGAL membuat tabel 'transactions'. Pesan: " . $e->getMessage() . "<br>";
}


echo "<br><b>Setup selesai. Anda bisa menghapus file ini sekarang untuk keamanan.</b>";

?>
