<?php
require_once 'components/database.php';
try {
    $pdo->exec("ALTER TABLE users ADD COLUMN full_name TEXT");
    $pdo->exec("ALTER TABLE users ADD COLUMN phone_number TEXT");
    $pdo->exec("ALTER TABLE users ADD COLUMN bio TEXT");
    echo "✅ Kolom Profile (Nama, HP, Bio) Berhasil Ditambahkan.";
} catch (Exception $e) {
    echo "ℹ️ Kolom mungkin sudah ada.";
}
?>