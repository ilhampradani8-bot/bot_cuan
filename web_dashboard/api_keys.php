<?php
// FILE: web_dashboard/api_keys.php
session_start();
require_once 'components/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

// Ambil info API yang sudah tersimpan
$stmt = $pdo->prepare("SELECT api_key, secret_key FROM bot_settings WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$saved = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Management - TradingSafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 h-screen flex flex-col overflow-hidden font-sans">

    <?php require_once 'components/navbar.php'; ?>

    <div class="flex flex-1 overflow-hidden relative">
        <?php require_once 'components/sidebar.php'; ?>

        <main class="flex-1 overflow-y-auto p-6 bg-slate-50 relative w-full">
            <button class="sidebar-toggle absolute top-4 left-4 md:hidden bg-white p-2 rounded-lg shadow-md border border-slate-200 text-slate-500 hover:text-blue-600 z-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
            </button>

            <div class="max-w-4xl mx-auto md:pl-0 pl-12">
                <div class="flex flex-col md:flex-row md:justify-between md:items-end mb-8 gap-4 border-b border-slate-200 pb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800 mb-1">Exchange API Management</h1>
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-widest">Markas Keamanan Bot Mas Ilham</p>
                    </div>
                    <button onclick="document.getElementById('api-modal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        [+] HUBUNGKAN API BARU
                    </button>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
                    <div class="p-6">
                        <?php if (!empty($saved['api_key'])): ?>
                            <div class="flex items-center justify-between p-5 border border-green-200 bg-green-50 rounded-2xl">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center font-black text-blue-600 border border-slate-100">ID</div>
                                    <div>
                                        <h4 class="font-bold text-slate-800">Indodax Primary Account</h4>
                                        <p class="text-[10px] font-mono text-slate-500 mt-1">Status: <span class="text-green-600 font-bold">CONNECTED</span></p>
                                    </div>
                                </div>
                                <button class="text-slate-300 hover:text-red-500 transition-colors" title="Disconnect Account">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-10">
                                <p class="text-sm text-slate-400 font-bold uppercase tracking-widest">Belum ada API yang terhubung</p>
                                <p class="text-xs text-slate-400 mt-2">Klik tombol di atas untuk memulai sniper trading.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-blue-900 text-blue-100 rounded-3xl p-8 relative overflow-hidden shadow-2xl">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-500/20 rounded-full blur-3xl"></div>
                    
                    <h4 class="font-bold text-white text-lg mb-6 flex items-center gap-3">
                        <span class="p-2 bg-blue-600 rounded-xl">📚</span>
                        SOP Koneksi API Indodax (Aman)
                    </h4>
                    
                    <div class="space-y-4">
                        <div class="flex gap-4">
                            <span class="w-6 h-6 rounded-full bg-blue-700 flex-shrink-0 flex items-center justify-center text-[10px] font-bold">1</span>
                            <p class="text-sm">Login ke <b>indodax.com</b>, buka menu <b>Profil > Trade API</b>.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="w-6 h-6 rounded-full bg-blue-700 flex-shrink-0 flex items-center justify-center text-[10px] font-bold">2</span>
                            <p class="text-sm">Buat label baru (misal: "Bot Cuan Ilham") dan centang izin <b>INFO</b> & <b>TRADE</b>.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="w-6 h-6 rounded-full bg-red-600 flex-shrink-0 flex items-center justify-center text-[10px] font-bold">!</span>
                            <p class="text-sm text-red-200"><b>PENTING:</b> Jangan centang <b>WITHDRAW</b> demi keamanan aset Mas!</p>
                        </div>
                        <div class="flex gap-4 border-t border-blue-800 pt-4 mt-4">
                            <span class="w-6 h-6 rounded-full bg-blue-700 flex-shrink-0 flex items-center justify-center text-[10px] font-bold">3</span>
                            <p class="text-sm">Input <b>API Key</b> dan <b>Secret Key</b> ke dalam modal [+] di atas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="api-modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-md z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-800">Hubungkan API Baru</h3>
                <button onclick="document.getElementById('api-modal').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="api/save_config.php" method="POST" class="p-8 space-y-5">
                <input type="hidden" name="mode" value="easy"> <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Bursa Kripto</label>
                    <select class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm font-bold">
                        <option>INDODAX (Indonesia)</option>
                        <option disabled>BINANCE (Global) - Soon</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">API Key</label>
                    <input type="text" name="api_key" placeholder="Paste API Key Mas" required class="w-full border border-slate-200 rounded-xl p-3 text-sm font-mono outline-none focus:border-blue-600">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Secret Key</label>
                    <input type="password" name="secret_key" placeholder="Paste Secret Key Mas" required class="w-full border border-slate-200 rounded-xl p-3 text-sm font-mono outline-none focus:border-blue-600">
                </div>
                <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-blue-600 transition-all shadow-xl">SIMPAN & VALIDASI</button>
            </form>
        </div>
    </div>

</body>
</html>