<?php
// FILE: web_dashboard/api/save_config.php
// Handles saving settings from both Easy Mode and API Keys page.

session_start();
require_once '../components/database.php';
require_once '../components/security.php'; // Now includes our new encryption functions

header('Content-Type: application/json');

// 1. Check Login
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Authentication required']);
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. Get Data from Input (supports both JSON and form-data)
$input = [];
if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
    $input = json_decode(file_get_contents('php://input'), true);
} else {
    $input = $_POST;
}

if (empty($input)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
    exit;
}

try {
    // 3. Prepare data to be saved
    $update_fields = [];
    $params = [];

    // --- Process each possible input field ---

    // API Keys (Encrypt them!)
    if (isset($input['api_key']) && isset($input['secret_key'])) {
        if (!empty($input['api_key']) && !empty($input['secret_key'])) {
            $update_fields[] = 'api_key = ?';
            $params[] = encrypt_key($input['api_key']); // Use encryption
            
            $update_fields[] = 'secret_key = ?';
            $params[] = encrypt_key($input['secret_key']); // Use encryption
        }
    }
    
    // Target Pair(s)
    if (isset($input['pair'])) {
        $update_fields[] = 'pair = ?';
        $params[] = strtoupper($input['pair']);
    }
    
    // Profit & Stop Loss
    if (isset($input['target_profit'])) {
        $update_fields[] = 'target_profit = ?';
        $params[] = $input['target_profit'];
    }
    if (isset($input['stop_loss'])) {
        $update_fields[] = 'stop_loss = ?';
        $params[] = $input['stop_loss'];
    }

    // Bot status (is_active)
    if (isset($input['is_active'])) {
         // Security check: Only premium users can activate the bot
        $stmtUser = $pdo->prepare("SELECT expired_at FROM users WHERE id = ?");
        $stmtUser->execute([$user_id]);
        $user = $stmtUser->fetch();
        $is_premium = ($user && $user['expired_at'] && new DateTime($user['expired_at']) > new DateTime());

        $is_active_value = ($is_premium && $input['is_active'] == 1) ? 1 : 0;
        $update_fields[] = 'is_active = ?';
        $params[] = $is_active_value;
    }
    
    // Special Toggles from Easy Mode
    if (isset($input['use_fixed_profit'])) {
        $update_fields[] = 'use_fixed_profit = ?';
        $params[] = (int)$input['use_fixed_profit'];
    }
     if (isset($input['use_auto_pilot'])) {
        $update_fields[] = 'use_auto_pilot = ?';
        $params[] = (int)$input['use_auto_pilot'];
    }

    // If there's nothing to update, exit.
    if (empty($update_fields)) {
        echo json_encode(['status' => 'success', 'message' => 'No changes detected.']);
        exit;
    }

    // 4. Check if a record for the user already exists
    $check_stmt = $pdo->prepare("SELECT id FROM bot_settings WHERE user_id = ?");
    $check_stmt->execute([$user_id]);
    $exists = $check_stmt->fetch();

    if ($exists) {
        // UPDATE existing record
        $sql = "UPDATE bot_settings SET " . implode(', ', $update_fields) . ", updated_at = CURRENT_TIMESTAMP WHERE user_id = ?";
        $params[] = $user_id;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    } else {
        // INSERT new record
        // We need to add user_id to the fields list for an insert
        $all_fields = array_map(function($field) { return explode(' =', $field)[0]; }, $update_fields);
        $all_fields[] = 'user_id';
        $placeholders = array_fill(0, count($all_fields), '?');
        
        $sql = "INSERT INTO bot_settings (" . implode(', ', $all_fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $params[] = $user_id; // Add user_id to the params list
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }

    // If the request came from the API key page, redirect back there
    if (isset($input['mode']) && $input['mode'] === 'easy') {
         header('Location: ../easy.php');
         exit;
    }

    echo json_encode(['status' => 'success', 'message' => 'Pengaturan berhasil disimpan!']);

} catch (Exception $e) {
    http_response_code(500);
    // Log the detailed error on the server, but don't show it to the user.
    error_log('Save Config Error: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan internal.']);
}
?>
