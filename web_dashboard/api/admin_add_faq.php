<?php
// File: web_dashboard/api/admin_add_faq.php
session_start();
header('Content-Type: application/json');

// Security Check: Ensure an admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403); // Forbidden
    echo json_encode(['success' => false, 'message' => 'Admin authentication required.']);
    exit;
}

// Include the database connection
require_once __DIR__ . '/../components/database.php';

// Get the POST data sent from the admin form as JSON
$input = json_decode(file_get_contents('php://input'), true);
$question = $input['question'] ?? '';
$answer = $input['answer'] ?? '';

// Basic validation to ensure fields are not empty
if (empty(trim($question)) || empty(trim($answer))) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Question and Answer cannot be empty.']);
    exit;
}

try {
    // Prepare the SQL statement to insert the new FAQ
    $stmt = $pdo->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
    
    // Execute the statement with the provided data
    $stmt->execute([$question, $answer]);
    
    // Get the ID of the newly inserted row to return to the frontend
    $newId = $pdo->lastInsertId();

    // Send a success response, including the new ID
    echo json_encode(['success' => true, 'message' => 'FAQ added successfully.', 'new_id' => $newId]);

} catch (PDOException $e) {
    // Handle potential database errors
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
