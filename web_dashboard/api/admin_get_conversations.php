<?php
// File: web_dashboard/api/admin_get_conversations.php

session_start();
header('Content-Type: application/json');

// Keamanan: Pastikan hanya admin yang bisa akses
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Admin authentication required.']);
    exit;
}

require_once __DIR__ . '/../components/database.php';

try {
    // Query ini mengambil:
    // 1. ID dan username dari setiap user yang pernah chat.
    // 2. Pesan terakhir dari percakapan tersebut.
    // 3. Waktu pesan terakhir dikirim.
    // 4. Jumlah pesan yang belum dibaca dari user tersebut.
    $stmt = $pdo->query("
        SELECT 
            u.id as user_id, 
            u.username,
            (SELECT message FROM support_chats WHERE user_id = u.id ORDER BY timestamp DESC LIMIT 1) as last_message,
            (SELECT timestamp FROM support_chats WHERE user_id = u.id ORDER BY timestamp DESC LIMIT 1) as last_message_time,
            SUM(CASE WHEN sc.is_read = 0 AND sc.sender = 'user' THEN 1 ELSE 0 END) as unread_count
        FROM support_chats sc
        JOIN users u ON sc.user_id = u.id
        GROUP BY u.id, u.username
        ORDER BY last_message_time DESC
    ");
    $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'conversations' => $conversations]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
