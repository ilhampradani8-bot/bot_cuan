<?php
// FILE: web_dashboard/api/get_portfolio.php
// v2 - Smarter Logic for Dynamic Exchanges

header('Content-Type: application/json');
session_start();

// --- DEPENDENCIES ---
try {
    require_once '../components/database.php';
    require_once '../components/security.php';
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Core component failed.', 'message' => $e->getMessage()]);
    exit;
}


// --- AUTHENTICATION ---
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Authentication required.']);
    exit;
}

// --- MASTER DATA & RESPONSE STRUCTURE ---
$user_id = $_SESSION['user_id'];

// Initial response structure with "0" instead of "N/A"
$response_data = [
    'total_balance_idr' => 0, 'balance_change_24h' => '+0.0%', 'active_bots' => 0, 'total_bots' => 0,
    'win_rate' => '0%', 'trade_count' => 0, 'connected_exchanges' => [], 'unconnected_exchanges' => [],
    'chart_data' => ['labels' => [], 'data' => [], 'colors' => ['#F97316', '#3B82F6', '#10B981', '#FBBF24', '#8B5CF6', '#EC4899']]
];

// Master list of all supported exchanges
// Load the master list of exchanges from the central file
require_once '../components/exchanges.php';



try {
    // --- Get user's actually connected exchanges from user_api_keys table ---
    $stmt = $pdo->prepare("SELECT DISTINCT exchange FROM user_api_keys WHERE user_id = ? AND status = 'active'");
    $stmt->execute([$user_id]);
    $user_connected_keys = $stmt->fetchAll(PDO::FETCH_COLUMN); // Returns a simple array like ['INDODAX', 'BINANCE']

    // --- Dynamically split exchanges into connected and unconnected lists ---
    foreach ($supported_exchanges as $key => $details) {
        if (in_array($key, $user_connected_keys)) {
            // For now, we only fetch balance for Indodax as an example
            if ($key === 'INDODAX') {
                // Here you would add logic to fetch balance for INDODAX
                // This is a placeholder structure
                $response_data['connected_exchanges'][] = [
                    'name' => $details['name'],
                    'icon' => $details['icon'],
                    'total_balance_idr' => 0, // Will be calculated later
                    'assets' => []
                ];
            } else {
                 $response_data['connected_exchanges'][] = [
                    'name' => $details['name'],
                    'icon' => $details['icon'],
                    'total_balance_idr' => 0,
                    'assets' => []
                ];
            }
        } else {
            $response_data['unconnected_exchanges'][] = $details;
        }
    }
    
    // --- Placeholder for fetching real balance data ---
    // In a real scenario, you would loop through each connected exchange and call its API.
    // For now, we are just showing the structure.

    echo json_encode($response_data);

} catch (Exception $e) {
    http_response_code(500);
    error_log('Portfolio API Error: ' . $e->getMessage());
    echo json_encode(['error' => 'An internal application error occurred.', 'message' => $e->getMessage()]);
}

?>
