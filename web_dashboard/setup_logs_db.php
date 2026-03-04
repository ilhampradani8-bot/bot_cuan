<?php
// web_dashboard/setup_logs_db.php
// Script untuk membuat tabel user_logs.

// Menggunakan path absolut untuk koneksi database yang andal
require_once __DIR__ . '/components/database.php';

try {
    // Perintah SQL untuk membuat tabel 'user_logs'
    // - id: Primary key unik untuk setiap log.
    // - user_id: Foreign key yang terhubung ke tabel 'users'.
    // - timestamp: Waktu kejadian log secara otomatis.
    // - action: Deskripsi aksi (e.g., 'login', 'logout', 'update_settings').
    // - ip_address: Alamat IP dari mana aksi dilakukan.
    // - details: Informasi tambahan (e.g., browser agent, atau detail perubahan).
    $sql = "
    CREATE TABLE IF NOT EXISTS user_logs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
        action TEXT NOT NULL,
        ip_address TEXT,
        details TEXT,
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
    );
    ";

    // Eksekusi perintah SQL
    $pdo->exec($sql);

    echo "Tabel 'user_logs' berhasil dibuat atau sudah ada.";

} catch (PDOException $e) {
    // Tampilkan pesan error jika pembuatan tabel gagal
    die("Error saat membuat tabel: " . $e->getMessage());
}
?>
