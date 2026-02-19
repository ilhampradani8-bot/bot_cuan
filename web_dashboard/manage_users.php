<?php
// web_dashboard/manage_users.php
session_start();
require_once 'components/database.php';

// --- 1. PROTEKSI ADMIN ---
if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// --- 2. LOGIKA AKTIVASI LANGGANAN (30 HARI) ---
if (isset($_GET['activate_id'])) {
    $id = $_GET['activate_id'];
    
    // Set masa aktif menjadi 30 hari dari sekarang
    $stmt = $pdo->prepare("UPDATE users SET expired_at = datetime('now', '+30 days') WHERE id = ?");
    $stmt->execute([$id]);
    
    echo "<script>alert('✅ Langganan user berhasil diaktifkan selama 30 hari!'); window.location='manage_users.php';</script>";
}

// --- 3. LOGIKA HAPUS USER ---
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    if ($_SESSION['user_id'] != $id) {
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
        echo "<script>alert('✅ User dihapus.'); window.location='manage_users.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Subscription Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen p-4 md:p-10">

    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        
        <div class="bg-slate-900 p-6 text-white flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold">TradingSafe Admin</h1>
                <p class="text-xs text-slate-400">Manajemen Pengguna & Langganan</p>
            </div>
            <a href="easy.php" class="bg-slate-700 hover:bg-slate-600 px-4 py-2 rounded-lg text-xs transition">Ke Dashboard</a>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs uppercase text-gray-400 border-b">
                        <th class="p-4 font-semibold">User</th>
                        <th class="p-4 font-semibold">Email</th>
                        <th class="p-4 font-semibold text-center">Status Akun</th>
                        <th class="p-4 font-semibold">Masa Aktif</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    <?php
                    $users = $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
                    foreach ($users as $u):
                        $isAdmin = ($u['username'] === 'admin');
                        
                        // Logika Cek Expired
                        $now = new DateTime();
                        $expiry = $u['expired_at'] ? new DateTime($u['expired_at']) : null;
                        $is_active = ($expiry && $expiry > $now);
                    ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            <div class="font-bold text-gray-800"><?= htmlspecialchars($u['username']) ?></div>
                            <?php if($u['google_id']): ?><span class="text-[10px] text-blue-500 uppercase font-bold">Google</span><?php endif; ?>
                        </td>
                        <td class="p-4 text-gray-600"><?= htmlspecialchars($u['email'] ?? '-') ?></td>
                        <td class="p-4 text-center">
                            <?php if($u['is_verified']): ?>
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-[10px] font-bold">VERIFIED</span>
                            <?php else: ?>
                                <span class="bg-gray-100 text-gray-400 px-2 py-1 rounded-full text-[10px]">PENDING</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4">
                            <?php if($is_active): ?>
                                <span class="text-green-600 font-medium">Aktif s/d: <br><b><?= $expiry->format('d M Y') ?></b></span>
                            <?php else: ?>
                                <span class="text-red-400 italic">Expired / Belum Langganan</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <?php if(!$isAdmin): ?>
                                <a href="?activate_id=<?= $u['id'] ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-[10px] font-bold transition">
                                    + 30 HARI
                                </a>
                                <a href="?delete_id=<?= $u['id'] ?>" onclick="return confirm('Hapus user ini?')" class="inline-block border border-red-200 text-red-500 hover:bg-red-50 px-3 py-1.5 rounded text-[10px] font-bold transition">
                                    HAPUS
                                </a>
                            <?php else: ?>
                                <span class="text-gray-300 text-xs italic">Sistem Utama</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="bg-gray-50 p-4 text-[10px] text-gray-400 text-center uppercase tracking-widest">
            Total Pengguna Terdaftar: <?= count($users) ?>
        </div>
    </div>

</body>
</html>