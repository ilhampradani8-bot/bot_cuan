<?php
// FILE: web_dashboard/components/logger.php

/**
 * Mencatat aktivitas user ke dalam tabel 'user_logs'.
 *
 * Fungsi ini dirancang untuk dipanggil dari berbagai bagian aplikasi
 * setiap kali ada tindakan penting yang perlu dicatat.
 *
 * @param PDO $pdo Objek koneksi database PDO yang aktif.
 * @param int $user_id ID dari user yang melakukan aksi.
 * @param string $action Deskripsi singkat dari aksi (cth: 'login_success', 'change_email').
 * @param string|null $details (Opsional) Detail tambahan tentang aksi, bisa berupa string atau JSON.
 */
// FILE: web_dashboard/components/logger.php

/**
 * Mencatat aktivitas user ke dalam tabel 'user_logs'.
 * (Versi 2: Secara manual memasukkan timestamp untuk kompatibilitas SQLite)
 */
function log_user_action($pdo, $user_id, $action, $details = null) {
    try {
        // Ambil IP Address
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

        // Buat timestamp dalam format yang ramah untuk database
        $timestamp = date('Y-m-d H:i:s');

        // Query INSERT sekarang menyertakan kolom 'timestamp'
        $sql = "INSERT INTO user_logs (user_id, action, ip_address, details, timestamp) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        
        // Eksekusi dengan menyertakan nilai timestamp
        $stmt->execute([$user_id, $action, $ip_address, $details, $timestamp]);

    } catch (PDOException $e) {
        // Catat error ke log server jika proses logging gagal
        error_log("Gagal mencatat log aksi pengguna: " . $e->getMessage());
    }
}

?>
