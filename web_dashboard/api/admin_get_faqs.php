<?php
// File: web_dashboard/api/admin_get_faqs.php

// Start session to verify admin login
session_start();

// Set header to return JSON response
header('Content-Type: application/json');

// Security Check: Ensure an admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403); // Forbidden
    echo json_encode(['success' => false, 'message' => 'Admin authentication required.']);
    exit;
}

// Include the database connection component
require_once __DIR__ . '/../components/database.php';

try {
    // Prepare and execute the SQL statement to fetch all FAQs
    // Order by creation date, newest first
    $stmt = $pdo->query("SELECT id, question, answer, is_active FROM faqs ORDER BY created_at DESC");
    
    // Fetch all results into an associative array
    $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Send a success response with the fetched data
    echo json_encode(['success' => true, 'faqs' => $faqs]);

} catch (PDOException $e) {
    // If there's a database error, send a server error response
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
