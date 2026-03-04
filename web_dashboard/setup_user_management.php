<?php
// File: web_dashboard/setup_user_management.php
// Menambah kolom yang dibutuhkan untuk fitur manajemen user di admin dashboard.

require_once 'components/database.php';

try {
    // 1. Add 'status' column to manage user account state (active, suspended, banned)
    $pdo->exec("ALTER TABLE users ADD COLUMN status TEXT NOT NULL DEFAULT 'active'");
    echo "✅ Kolom 'status' berhasil ditambahkan ke tabel users.<br>";

    // 2. Add 'last_login' column to track user activity
    $pdo->exec("ALTER TABLE users ADD COLUMN last_login DATETIME DEFAULT NULL");
    echo "✅ Kolom 'last_login' berhasil ditambahkan ke tabel users.<br>";

    echo "<br><b>Setup selesai. Silakan hapus file ini.</b>";

} catch (Exception $e) {
    // Pesan ini akan muncul jika salah satu atau semua kolom sudah ada sebelumnya.
    echo "ℹ️ Salah satu atau semua kolom mungkin sudah ada sebelumnya. Pesan error: " . $e->getMessage();
}
?>
