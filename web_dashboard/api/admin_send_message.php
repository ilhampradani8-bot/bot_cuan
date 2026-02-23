<?php
// File: web_dashboard/api/admin_send_message.php

session_start();
header('Content-Type: application/json');

// Keamanan: Pastikan admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Admin authentication required.']);
    exit;
}

require_once __DIR__ . '/../components/database.php';

// Baca data JSON yang dikirim dari JavaScript
$input = json_decode(file_get_contents('php://input'), true);
$user_id = $input['user_id'] ?? null;
$message = $input['message'] ?? '';

// Validasi input
if (empty($user_id) || empty(trim($message))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'User ID and message cannot be empty.']);
    exit;
}

try {
    // Simpan balasan admin ke database
    $stmt = $pdo->prepare(
        "INSERT INTO support_chats (user_id, message, sender) VALUES (?, ?, 'admin')"
    );
    $stmt->execute([$user_id, $message]);

    echo json_encode(['success' => true, 'message' => 'Reply sent successfully.']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
