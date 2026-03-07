<?php
// FILE: web_dashboard/setup_trade_history_db.php
// Script untuk membuat tabel 'trade_history' yang akan menyimpan setiap hasil trading.

require_once __DIR__ . '/components/database.php';

try {
    // Perintah SQL untuk membuat tabel 'trade_history'
    // - id: Primary key unik.
    // - user_id: Terhubung ke 'users'.
    // - bot_id: Terhubung ke 'bot_settings'.
    // - pair: Pasangan koin yang ditradingkan (cth: BTC/IDR).
    // - status: Status akhir trade ('closed', 'cancelled').
    // - profit_amount: Jumlah keuntungan atau kerugian dalam Rupiah (bisa negatif).
    // - timestamp: Waktu trade dieksekusi.
    $sql = "
    CREATE TABLE IF NOT EXISTS trade_history (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        bot_id INTEGER NOT NULL,
        pair TEXT NOT NULL,
        status TEXT NOT NULL CHECK(status IN ('closed', 'cancelled')),
        profit_amount REAL NOT NULL,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users (id),
        FOREIGN KEY (bot_id) REFERENCES bot_settings (id)
    );
    ";

    // Eksekusi perintah SQL
    $pdo->exec($sql);

    echo "✅ SUKSES! Tabel 'trade_history' berhasil dibuat atau sudah ada.";

} catch (PDOException $e) {
    // Tampilkan pesan error jika pembuatan tabel gagal
    die("❌ GAGAL: Error saat membuat tabel 'trade_history': " . $e->getMessage());
}
?>
