<?php
// File: web_dashboard/api/send_message.php

// Start session to identify the logged-in user
session_start();

// Set header to return JSON response
header('Content-Type: application/json');

// 1. Security Check: Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, send an error response and exit
    echo json_encode(['success' => false, 'message' => 'Authentication required.']);
    exit;
}

// 2. Include Database Connection
// Use __DIR__ to ensure the path is correct from this file's location
require_once __DIR__ . '/../components/database.php';

// 3. Get Input Data
// Reads the raw POST data from the fetch request
$input = json_decode(file_get_contents('php://input'), true);
$message = $input['message'] ?? '';

// 4. Validate Input
if (empty(trim($message))) {
    // If message is empty, send an error response
    echo json_encode(['success' => false, 'message' => 'Message cannot be empty.']);
    exit;
}

// 5. Prepare and Save to Database
try {
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $pdo->prepare(
        "INSERT INTO support_chats (user_id, message, sender) VALUES (?, ?, ?)"
    );

    // Execute the statement with the user's data
    // user_id is from the session, message is from input, sender is hardcoded to 'user'
    $stmt->execute([
        $_SESSION['user_id'],
        $message,
        'user' 
    ]);

    // Send success response
    echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);

} catch (PDOException $e) {
    // If there's a database error, send a server error response
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

?>
