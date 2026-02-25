<?php
// components/database.php

// GUNAKAN ABSOLUTE PATH (Jalur Pasti) KE DATABASE UTAMA RUST
// Sesuaikan dengan path server Mas: /home/ilham/projects/bot_cuan/bot_cuan.db
// PASTE BLOK BARU INI
// Use a relative path to locate the database file.
// __DIR__ gets the directory of the current file (components).
// '/../../' goes up two levels to the project root.
$db_path = __DIR__ . '/../../bot_cuan.db';


try {
    $pdo = new PDO("sqlite:" . $db_path);
    
    // Setel mode error & pengembalian data
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Melempar kembali error agar bisa ditangkap oleh script yang memanggil,
    // bukannya mematikan aplikasi secara paksa. Ini adalah praktik yang benar.
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}


?>