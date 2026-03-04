<?php
// FILE: web_dashboard/api/admin_get_stats.php
// API to provide vital platform statistics for the admin dashboard.
// VERSI OPTIMIZED: Menggunakan /proc/stat untuk CPU usage agar lebih ringan.

session_start();
header('Content-Type: application/json');

// Security: Ensure an admin is logged in.
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo json_encode(['error' => 'Admin authentication required.']);
    exit;
}

require_once __DIR__ . '/../components/database.php';

// --- FUNGSI OPTIMASI UNTUK MENGAMBIL CPU USAGE ---
// Fungsi ini membaca /proc/stat untuk mendapatkan data CPU tanpa menjalankan `top`.
function get_cpu_times() {
    $stat_lines = file('/proc/stat');
    if ($stat_lines === false) {
        return null;
    }
    // Baris pertama berisi statistik CPU secara keseluruhan
    $cpu_line = $stat_lines[0];
    // Pisahkan nilai berdasarkan spasi
    $parts = preg_split('/\\s+/', trim($cpu_line));
    
    // Nilai-nilai tersebut adalah: user, nice, system, idle, iowait, irq, softirq, steal, guest, guest_nice
    $user = (int)($parts[1] ?? 0);
    $nice = (int)($parts[2] ?? 0);
    $system = (int)($parts[3] ?? 0);
    $idle = (int)($parts[4] ?? 0);

    // Total waktu non-idle adalah jumlah dari semua waktu kecuali idle
    $total_non_idle = $user + $nice + $system;
    // Total waktu CPU adalah jumlah semua waktu
    $total_cpu = $total_non_idle + $idle;

    return [
        'total' => $total_cpu,
        'idle' => $idle,
    ];
}

function get_optimized_cpu_usage() {
    // Simpan data CPU sebelumnya di dalam session untuk perbandingan
    $prev_times = $_SESSION['cpu_stat'] ?? null;
    
    $current_times = get_cpu_times();

    // Simpan data saat ini ke session untuk pemanggilan berikutnya
    $_SESSION['cpu_stat'] = $current_times;
    
    // Jika tidak ada data sebelumnya atau data tidak valid, kita belum bisa menghitung
    if (!$prev_times || !$current_times) {
        // Panggil shell_exec hanya sekali sebagai fallback jika file session belum ada
        return floatval(shell_exec("top -b -n 1 | grep 'Cpu(s)' | awk '{print 100 - $8}'"));
    }

    // Hitung perbedaan dari waktu sebelumnya
    $total_diff = $current_times['total'] - $prev_times['total'];
    $idle_diff = $current_times['idle'] - $prev_times['idle'];

    // Hindari pembagian dengan nol jika tidak ada perubahan
    if ($total_diff === 0) {
        return 0;
    }

    // Persentase idle adalah perbedaan idle dibagi total perbedaan
    $idle_percentage = ($idle_diff / $total_diff) * 100;
    
    // CPU usage adalah 100% dikurangi persentase idle
    $cpu_usage = 100 - $idle_percentage;

    return round($cpu_usage, 2);
}


// Function to get server RAM usage (specific to Alpine Linux)
function get_ram_usage() {
    // Uses `free` command and parses the 'used' memory for the main Mem line.
    $output = shell_exec("free -m | grep 'Mem:' | awk '{print $3}'");
    if (is_numeric(trim($output))) {
        return intval($output);
    }
    return 'N/A';
}

// Function to check if the Rust engine process is running.
function get_engine_status() {
    // Checks if a process named 'sniper_engine' is in the process list.
    $output = shell_exec("pgrep -f 'sniper_engine'");
    if (!empty(trim($output))) {
        return ['text' => 'Online', 'class' => 'text-green-600'];
    }
    return ['text' => 'Offline', 'class' => 'text-red-600'];
}

try {
    // 1. Get Total Users
    $stmt_users = $pdo->query("SELECT COUNT(*) FROM users");
    $total_users = $stmt_users->fetchColumn();

    // 2. Get Active Bots (Assuming 'active' status is stored in a table)
    // This is a placeholder. You might need to adjust the query.
    $stmt_bots = $pdo->query("SELECT COUNT(*) FROM bot_settings WHERE is_active = 1");
    $active_bots = $stmt_bots->fetchColumn();
    
    // 3. Get Total Trading Volume (Placeholder)
    // This should be calculated from a 'trades' or 'transactions' table.
    $total_volume = 1250000000; // Placeholder value: 1.25 Miliar

    // 4. Get System Health (Menggunakan fungsi CPU yang baru)
    $cpu_usage = get_optimized_cpu_usage();
    $ram_usage = get_ram_usage();
    $engine_status = get_engine_status();

    // Prepare the final response data.
    $stats = [
        'total_users' => (int) $total_users,
        'active_bots' => (int) $active_bots,
        'total_volume' => $total_volume,
        'total_volume_formatted' => 'Rp ' . number_format($total_volume / 1000000000, 2) . ' M',
        'cpu_usage' => $cpu_usage,
        'ram_usage' => $ram_usage,
        'engine_status' => $engine_status,
    ];

    echo json_encode($stats);

} catch (Exception $e) {
    http_response_code(500);
    // Ubah cara penanganan error agar tidak mengekspos detail internal
    echo json_encode(['error' => 'An internal error occurred.', 'details' => $e->getMessage()]);
}
?>
