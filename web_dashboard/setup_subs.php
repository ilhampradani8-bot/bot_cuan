<?php
require_once 'components/database.php';
try {
    // Tambah kolom expired_at untuk cek masa aktif
    $pdo->exec("ALTER TABLE users ADD COLUMN expired_at DATETIME");
    echo "✅ Kolom 'expired_at' berhasil ditambahkan.";
} catch (Exception $e) {
    echo "ℹ️ Kolom mungkin sudah ada.";
}
?>