<?php
// File: web_dashboard/api/admin_get_messages.php

session_start();
header('Content-Type: application/json');

// Keamanan: Pastikan admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Admin authentication required.']);
    exit;
}

// Keamanan: Pastikan user_id dikirim
if (!isset($_GET['user_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'User ID is required.']);
    exit;
}

require_once __DIR__ . '/../components/database.php';

$user_id = $_GET['user_id'];

try {
    // 1. Ambil semua pesan untuk user_id yang dipilih
    $stmt = $pdo->prepare(
        "SELECT message, sender, timestamp 
         FROM support_chats 
         WHERE user_id = ? 
         ORDER BY timestamp ASC"
    );
    $stmt->execute([$user_id]);
    $messages = $stmt->fetchAll();

    // 2. Tandai semua pesan dari user ini sebagai "sudah dibaca"
    $updateStmt = $pdo->prepare(
        "UPDATE support_chats SET is_read = 1 WHERE user_id = ? AND sender = 'user'"
    );
    $updateStmt->execute([$user_id]);

    // 3. Kirim data pesan sebagai JSON
    echo json_encode(['success' => true, 'messages' => $messages]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
