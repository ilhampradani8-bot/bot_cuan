<?php
// FILE: web_dashboard/api/get_server_stats.php

session_start();
header('Content-Type: application/json');

// Keamanan: Pastikan hanya admin yang login yang bisa mengakses.
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo json_encode(['error' => 'Akses ditolak']);
    exit;
}

// --- Helper Function ---
function formatBytes($bytes, $precision = 2) {
    if ($bytes <= 0) return '0 Bytes';
    $base = log($bytes, 1024);
    $suffixes = array('Bytes', 'KB', 'MB', 'GB', 'TB');
    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}

$stats = [];

// ===========================================
// 1. Ambil CPU Load
// ===========================================
if (function_exists('sys_getloadavg')) {
    $cpu_load = sys_getloadavg();
    $stats['cpu'] = round($cpu_load[0] * 100, 1);
} else {
    $stats['cpu'] = 'N/A';
}

// ===========================================
// 2. Ambil Disk Usage
// ===========================================
$disk_free = @disk_free_space('/');
$disk_total = @disk_total_space('/');

if ($disk_free !== false && $disk_total !== false) {
    $disk_used = $disk_total - $disk_free;
    $stats['disk'] = [
        'total_formatted' => formatBytes($disk_total),
        'free_formatted' => formatBytes($disk_free),
        'used_formatted' => formatBytes($disk_used),
        'percentage_used' => $disk_total > 0 ? round(($disk_used / $disk_total) * 100, 1) : 0
    ];
} else {
     $stats['disk'] = ['error' => 'Could not retrieve disk stats.'];
}

// ===========================================
// 3. Ambil Memory Usage (Khusus Linux)
// ===========================================
$meminfo_path = '/proc/meminfo';
if (is_readable($meminfo_path)) {
    $meminfo_content = file_get_contents($meminfo_path);
    preg_match('/MemTotal:\s+(\d+) kB/', $meminfo_content, $matches_total);
    preg_match('/MemAvailable:\s+(\d+) kB/', $meminfo_content, $matches_available);

    if (isset($matches_total[1]) && isset($matches_available[1])) {
        $mem_total_kb = (int)$matches_total[1];
        $mem_available_kb = (int)$matches_available[1];
        $mem_used_kb = $mem_total_kb - $mem_available_kb;

        $stats['memory'] = [
            'total_formatted' => formatBytes($mem_total_kb * 1024),
            'used_formatted' => formatBytes($mem_used_kb * 1024),
            'percentage_used' => $mem_total_kb > 0 ? round(($mem_used_kb / $mem_total_kb) * 100, 1) : 0
        ];
    } else {
         $stats['memory'] = ['error' => 'Could not parse meminfo.'];
    }
} else {
    $stats['memory'] = ['error' => 'Not a Linux system or cannot read /proc/meminfo.'];
}

// ===========================================
// 4. Cek Status Bot Engine (dari file konfigurasi)
// ===========================================
$stats['bots'] = [];
$config_path = '../config/bot_config.json';

if (file_exists($config_path)) {
    $config_content = file_get_contents($config_path);
    $config = json_decode($config_content, true);

    if (isset($config['bots']) && is_array($config['bots'])) {
        foreach ($config['bots'] as $bot) {
            if (isset($bot['name']) && isset($bot['process_name'])) {
                $process_name = $bot['process_name'];
                
                // Gunakan pgrep untuk memeriksa apakah proses berjalan
                system("pgrep -x " . escapeshellarg($process_name) . " > /dev/null 2>&1", $return_var);
                
                $stats['bots'][] = [
                    'name' => $bot['name'],
                    'status' => ($return_var === 0) ? 'Running' : 'Stopped'
                ];
            }
        }
    }
} else {
    // Jika file config tidak ada, kembalikan array kosong
    $stats['bots'] = [];
}


// ===========================================
// Final Output
// ===========================================
echo json_encode($stats);

?>
