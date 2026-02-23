<?php
// File: web_dashboard/api/get_messages.php

session_start();
header('Content-Type: application/json');

// Keamanan: Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Authentication required.']);
    exit;
}

require_once __DIR__ . '/../components/database.php';

$user_id = $_SESSION['user_id'];

try {
    // 1. Ambil semua pesan untuk user ini dari database
    $stmt = $pdo->prepare(
        "SELECT message, sender, timestamp 
         FROM support_chats 
         WHERE user_id = ? 
         ORDER BY timestamp ASC"
    );
    $stmt->execute([$user_id]);
    $messages = $stmt->fetchAll();

    // 2. Tandai pesan dari admin yang belum dibaca menjadi "sudah dibaca"
    // Ini dijalankan setelah pesan diambil, agar notifikasi di admin hilang.
    $updateStmt = $pdo->prepare(
        "UPDATE support_chats SET is_read = 1 WHERE user_id = ? AND sender = 'admin' AND is_read = 0"
    );
    $updateStmt->execute([$user_id]);

    // 3. Kirim data pesan dalam format JSON
    echo json_encode(['success' => true, 'messages' => $messages]);

} catch (PDOException $e) {
    // Kirim pesan error jika koneksi/query database gagal
    http_response_code(500); // Kode error server
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

?>
