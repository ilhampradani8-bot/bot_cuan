<?php
// =================================================================================
// 1. PHP LOGIC BLOCK
// =================================================================================
session_start();
require_once 'components/database.php';

// A. Cek Login
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$user_id = $_SESSION['user_id'];

// B. Default Variables
$is_expired = true; $days_left = 0; $is_verified = 0; $is_pending_payment = false;
$bot_settings = ['pair' => '', 'target_profit' => '', 'stop_loss' => '', 'api_key' => '', 'secret_key' => ''];

try {
    // Ambil Data User
    $stmt = $pdo->prepare("SELECT expired_at, full_name, phone_number, is_verified, email, username FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $userProfile = $stmt->fetch();

    if ($userProfile && $userProfile['expired_at']) {
        $now = new DateTime(); $expiry = new DateTime($userProfile['expired_at']);
        if ($expiry > $now) {
            $is_expired = false;
            $diff = $now->diff($expiry);
            $days_left = $diff->days;
        }
    }
    // Cek Payment Pending
    if ($is_expired) {
        $stmtTrx = $pdo->prepare("SELECT id FROM transactions WHERE user_id = ? AND status = 'pending' ORDER BY id DESC LIMIT 1");
        $stmtTrx->execute([$user_id]);
        if ($stmtTrx->fetch()) $is_pending_payment = true;
    }
    // Ambil Setting Bot
    $stmtBot = $pdo->prepare("SELECT * FROM bot_settings WHERE user_id = ?");
    $stmtBot->execute([$user_id]);
    $saved = $stmtBot->fetch();
    if ($saved) $bot_settings = $saved;

} catch (Exception $e) {}

// LOGIKA STATUS EXCHANGE (HIJAU/ABU)
// Indodax hijau kalau API Key terisi
$status_indodax = !empty($bot_settings['api_key']) ? 'text-green-500 bg-green-50 border-green-200' : 'text-slate-300 grayscale opacity-50';
// Exchange lain sementara abu-abu (Placeholder)
$status_inactive = 'text-slate-300 grayscale opacity-50';

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Mode - TradingSafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .nav-active { background-color: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen pb-20">

    <?php require_once 'components/navbar.php'; ?>


    <main class="max-w-7xl mx-auto px-4 space-y-6 mt-6">
        
        <section id="status-banners" class="space-y-4">
            <?php if ($is_verified === 0): ?>
            <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-r-lg shadow-sm flex items-center gap-4">
                <span class="text-2xl">📧</span>
                <div><h4 class="text-sm font-bold text-orange-900">Email Belum Verif</h4></div>
                <a href="verify.php" class="ml-auto bg-orange-600 text-white px-4 py-1.5 rounded text-xs font-bold">Verifikasi</a>
            </div>
            <?php endif; ?>

            <?php if ($is_pending_payment): ?>
                <div class="bg-indigo-50 border-l-4 border-indigo-500 p-6 rounded-r-lg shadow-sm animate-pulse flex items-center gap-4">
                    <span class="text-3xl">⏳</span>
                    <div><h4 class="text-lg font-bold text-indigo-900">Pembayaran Diproses</h4></div>
                </div>
            <?php elseif ($is_expired): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-lg shadow-sm flex justify-between items-center">
                    <div><p class="text-lg font-bold text-red-900">Mode Simulasi (Free)</p></div>
                    <a href="upgrade.php" class="bg-red-600 text-white px-6 py-2 rounded-lg text-sm font-bold shadow-lg shadow-red-200">UPGRADE</a>
                </div>
            <?php else: ?>
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 rounded-2xl text-white shadow-xl shadow-blue-200 flex justify-between items-center">
                    <div>
                        <p class="text-blue-200 text-[10px] uppercase font-bold tracking-widest">Status Akun</p>
                        <h2 class="text-xl font-bold flex items-center gap-2">Premium Active <span class="bg-white/20 text-[10px] px-2 py-0.5 rounded-full">PRO</span></h2>
                    </div>
                    <div class="text-right">
                        <p class="text-4xl font-black"><?= $days_left ?><span class="text-sm font-normal opacity-70">Hari</span></p>
                    </div>
                </div>
            <?php endif; ?>
        </section>

        <section class="grid md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-6">⚙️ Konfigurasi Bot</h3>
                <form id="bot-form" class="space-y-4">
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase mb-3 border-b border-slate-200 pb-2">Koneksi Indodax</h4>
                        <div class="space-y-3">
                            <input type="text" id="api_key" value="<?= htmlspecialchars($bot_settings['api_key'] ?? '') ?>" placeholder="API Key" class="w-full border border-slate-200 rounded-lg p-2 text-xs font-mono">
                            <input type="password" id="secret_key" value="<?= htmlspecialchars($bot_settings['secret_key'] ?? '') ?>" placeholder="Secret Key" class="w-full border border-slate-200 rounded-lg p-2 text-xs font-mono">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Pair</label>
                        <input type="text" id="pair" value="<?= htmlspecialchars($bot_settings['pair'] ?? '') ?>" placeholder="BTC/IDR" class="w-full border border-slate-200 rounded-xl p-3 text-sm font-bold uppercase">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Profit %</label>
                            <input type="number" id="target_profit" value="<?= htmlspecialchars($bot_settings['target_profit'] ?? '') ?>" placeholder="1.5" step="0.1" class="w-full border border-slate-200 rounded-xl p-3 text-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Stop Loss %</label>
                            <input type="number" id="stop_loss" value="<?= htmlspecialchars($bot_settings['stop_loss'] ?? '') ?>" placeholder="2.0" step="0.1" class="w-full border border-slate-200 rounded-xl p-3 text-sm">
                        </div>
                    </div>

                    <?php if ($is_expired): ?>
                        <a href="upgrade.php" class="block w-full bg-slate-200 text-slate-500 py-3 rounded-xl font-bold text-center text-xs">🔒 UPGRADE DULU</a>
                        <button type="button" onclick="saveConfig(0)" class="w-full text-xs text-blue-600 font-bold mt-2">Simpan Config Saja</button>
                    <?php else: ?>
                        <div class="flex gap-2">
                            <button type="button" onclick="saveConfig(0)" class="w-1/3 bg-white border border-slate-200 text-slate-600 py-3 rounded-xl font-bold text-xs">STOP</button>
                            <button type="button" onclick="saveConfig(1)" class="w-2/3 bg-slate-900 text-white py-3 rounded-xl font-bold text-xs hover:bg-slate-800 shadow-lg">START ENGINE</button>
                        </div>
                    <?php endif; ?>
                </form>
            </div>

            <div class="bg-slate-900 text-slate-300 p-6 rounded-2xl font-mono text-xs overflow-hidden flex flex-col h-full min-h-[300px]">
                <h3 class="text-white font-bold mb-4 flex items-center gap-2 font-sans">
                    <span class="w-2 h-2 <?= $is_expired ? 'bg-red-500' : 'bg-green-500' ?> rounded-full animate-pulse"></span>
                    Terminal
                </h3>
                <div id="log-area" class="flex-1 space-y-2 overflow-y-auto max-h-[400px] scrollbar-hide">
                    <p class="text-slate-500">[System] Dashboard Loaded.</p>
                    <?php if(isset($bot_settings['is_active']) && $bot_settings['is_active'] == 1): ?>
                        <p class="text-green-500">[Engine] RUNNING...</p>
                    <?php else: ?>
                        <p class="text-slate-500">[Engine] IDLE.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <script>
    async function saveConfig(isActive) {
        const btn = event.target; btn.innerHTML = "..."; btn.disabled = true;
        const data = {
            api_key: document.getElementById('api_key').value,
            secret_key: document.getElementById('secret_key').value,
            pair: document.getElementById('pair').value,
            target_profit: document.getElementById('target_profit').value,
            stop_loss: document.getElementById('stop_loss').value,
            is_active: isActive
        };
        try {
            await fetch('api/save_config.php', { method: 'POST', body: JSON.stringify(data) });
            alert("✅ Tersimpan!");
            if(isActive !== undefined) setTimeout(() => location.reload(), 500);
        } catch (e) { alert("❌ Gagal"); }
        btn.disabled = false;
    }
    </script>
</body>
</html>