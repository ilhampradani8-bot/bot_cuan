<?php
// FILE: web_dashboard/api/manage_keys.php
// REFACTOR: Converted from a classic redirect-based script to a modern, pure JSON API endpoint.
// This is to make it compatible with the new JavaScript-driven settings page.

session_start();
header('Content-Type: application/json'); // Rule 1: Always declare that the response is JSON.

// --- UTILITIES (to ensure we always respond with JSON) ---
function send_json_response($data) {
    echo json_encode($data);
    exit;
}
function send_json_error($message, $http_code = 500) {
    http_response_code($http_code);
    send_json_response(['error' => $message]);
}
// --- END UTILITIES ---

// Stop immediately if the user is not logged in.
if (!isset($_SESSION['user_id'])) {
    send_json_error('Authentication required.', 403);
}

// Safely require necessary components. Use '@' to suppress warnings and handle errors manually.
@require_once __DIR__ . '/../components/database.php';
@require_once __DIR__ . '/../components/encryption.php';

// Check if dependencies were loaded correctly.
if (!isset($pdo) || !function_exists('encrypt_data') || !function_exists('decrypt_data')) {
    send_json_error('Server configuration error: Missing critical components (database or encryption).');
}

$user_id = $_SESSION['user_id'];
// Determine action from POST (for save/delete) or GET (for get_all).
$action = $_POST['action'] ?? $_GET['action'] ?? null; 

switch ($action) {

    // ==========================================================
    // ACTION: GET ALL KEYS (New, essential function for the UI)
    // ==========================================================
    // ==========================================================
// ACTION: GET ALL KEYS (New, essential function for the UI)
// ==========================================================
case 'get_all':
    try {
        // Prepare and execute the query to get user's keys.
        $stmt = $pdo->prepare("SELECT id, exchange, api_key, status FROM user_api_keys WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $keys_from_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $formatted_keys = [];
        foreach ($keys_from_db as $key) {
            // Decrypt the API key for use in the edit form.
            $decrypted_api_key = decrypt_data($key['api_key'], ENCRYPTION_KEY);
            $formatted_keys[] = [
                'id' => $key['id'],
                'exchange' => $key['exchange'],
                'api_key' => $decrypted_api_key,
                'api_key_masked' => substr($decrypted_api_key, 0, 4) . '...' . substr($decrypted_api_key, -4),
                'status' => $key['status'] ?? 'UNVERIFIED',
                'logo' => 'https://cdn.jsdelivr.net/gh/atomiclabs/cryptocurrency-icons@1a63530be6e374711a8554f31b17e4cb92c25fa5/32/color/' . strtolower($key['exchange']) . '.png'
            ];
        }

        // FIX: Include the 'supported_exchanges' array in the response.
        // The frontend needs this data to populate the dropdown menu.
        send_json_response([
            'keys' => $formatted_keys,
            'supported_exchanges' => ['INDODAX', 'BINANCE', 'BYBIT', 'OKX', 'KUCOIN', 'BITGET']
        ]);

    } catch (Exception $e) {
        // Send a structured error if anything fails.
        send_json_error('Could not retrieve API keys: ' . $e->getMessage());
    }
    break;


    // ==========================================================
    // ACTION: SAVE KEY (Handles both ADD and UPDATE)
    // ==========================================================
    case 'save':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { send_json_error('Invalid request method.', 405); }
        
        $key_id = $_POST['key_id'] ?? null; // If key_id exists, it's an update.
        $exchange = $_POST['exchange'] ?? null;
        $api_key = $_POST['api_key'] ?? null;
        $secret_key = $_POST['secret_key'] ?? null;

        if (empty($exchange) || empty($api_key)) { send_json_error('Exchange and API Key are required.', 400); }

        try {
            // Logic for UPDATE
            if (!empty($key_id)) {
                $encrypted_api = encrypt_data($api_key, ENCRYPTION_KEY);
                // Only update secret key if a new one is provided.
                if (!empty($secret_key)) {
                    $encrypted_secret = encrypt_data($secret_key, ENCRYPTION_KEY);
                    $stmt = $pdo->prepare("UPDATE user_api_keys SET exchange = ?, api_key = ?, secret_key = ? WHERE id = ? AND user_id = ?");
                    $stmt->execute([$exchange, $encrypted_api, $encrypted_secret, $key_id, $user_id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE user_api_keys SET exchange = ?, api_key = ? WHERE id = ? AND user_id = ?");
                    $stmt->execute([$exchange, $encrypted_api, $key_id, $user_id]);
                }
                send_json_response(['success' => 'API Key updated successfully.']);
            } 
            // Logic for ADD
            else {
                if (empty($secret_key)) { send_json_error('Secret Key is required for new keys.', 400); }
                $encrypted_api = encrypt_data($api_key, ENCRYPTION_KEY);
                $encrypted_secret = encrypt_data($secret_key, ENCRYPTION_KEY);

                $stmt = $pdo->prepare("INSERT INTO user_api_keys (user_id, exchange, api_key, secret_key, status) VALUES (?, ?, ?, ?, 'UNVERIFIED')");
                $stmt->execute([$user_id, $exchange, $encrypted_api, $encrypted_secret]);
                send_json_response(['success' => 'API Key added successfully.']);
            }
        } catch (Exception $e) {
            send_json_error('Error saving API Key: ' . $e->getMessage());
        }
        break;

    // ==========================================================
    // ACTION: DELETE A KEY
    // ==========================================================
    case 'delete':
         if ($_SERVER['REQUEST_METHOD'] !== 'POST') { send_json_error('Invalid request method.', 405); }
        
        $key_id = $_POST['key_id'] ?? null;
        if (empty($key_id)) { send_json_error('Invalid ID for deletion.', 400); }

        try {
            $stmt = $pdo->prepare("DELETE FROM user_api_keys WHERE id = ? AND user_id = ?");
            $stmt->execute([$key_id, $user_id]);
            
            if ($stmt->rowCount() > 0) {
                send_json_response(['success' => 'API Key has been deleted.']);
            } else {
                send_json_error('Could not delete key. It may not exist or you may not have permission.', 404);
            }
        } catch (Exception $e) {
            send_json_error('Error deleting API Key: ' . $e->getMessage());
        }
        break;

    default:
        send_json_error('No valid action specified.', 400);
        break;
}
?>
