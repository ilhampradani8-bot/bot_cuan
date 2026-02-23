<?php
// Start the session to store login state
session_start();

// --- Hardcoded Admin Credentials ---
// For now, we use simple, non-database credentials.
$admin_user = 'admin';
$admin_pass = 'admin123';
// -----------------------------------

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get username and password from the form
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate the credentials
    if ($username === $admin_user && $password === $admin_pass) {
        // --- Login Successful ---
        
        // Set a session variable to mark the admin as logged in
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        
        // Redirect to the protected dashboard
        header("Location: dashboard.php");
        exit; // Important: stop script execution after redirection

    } else {
        // --- Login Failed ---
        
        // Redirect back to the login page with an error flag
        header("Location: index.php?error=1");
        exit;
    }

} else {
    // If accessed directly, just redirect to the login page
    header("Location: index.php");
    exit;
}
?>
