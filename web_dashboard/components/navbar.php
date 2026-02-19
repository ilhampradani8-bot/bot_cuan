<?php
// Cek halaman mana yang sedang dibuka (biar tombol aktif otomatis nyala)
$current_page = basename($_SERVER['PHP_SELF']); 

// Logic Warna Tombol
$btn_easy = ($current_page == 'easy.php') ? 'bg-white text-blue-600 shadow-sm border border-slate-200' : 'text-slate-400 hover:text-slate-600';
$btn_pro  = ($current_page == 'pro.php') ? 'bg-white text-blue-600 shadow-sm border border-slate-200' : 'text-slate-400 hover:text-slate-600';

// Logic Status Koneksi (Indodax Hijau jika API Key ada)
// Kita anggap variabel $bot_settings sudah tersedia dari file induk (easy.php/pro.php)
$api_filled = !empty($bot_settings['api_key']);
$status_indodax = $api_filled ? 'text-green-600 bg-green-50 border-green-200' : 'text-slate-300 grayscale opacity-50 border-transparent';
$dot_indodax    = $api_filled ? 'bg-green-500 animate-pulse' : 'bg-slate-300';

$status_inactive = 'text-slate-300 grayscale opacity-50 border-transparent';
?>

<nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 h-16 flex justify-between items-center">
        
        <div class="flex items-center gap-8">
            <div class="text-xl font-extrabold text-slate-900 tracking-tight">TradingSafe<span class="text-blue-600">.</span></div>
            
            <div class="hidden md:flex bg-slate-100 p-1 rounded-lg border border-slate-200">
                <a href="easy.php" class="px-4 py-1.5 rounded-md text-xs font-bold transition <?= $btn_easy ?>">
                    EASY MODE
                </a>
                <a href="pro.php" class="px-4 py-1.5 rounded-md text-xs font-bold transition <?= $btn_pro ?>">
                    PRO MODE
                </a>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-2">
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-[10px] font-bold transition <?= $status_indodax ?>">
                <div class="w-1.5 h-1.5 rounded-full <?= $dot_indodax ?>"></div>
                INDODAX
            </div>
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-transparent text-[10px] font-bold <?= $status_inactive ?>">
                <div class="w-1.5 h-1.5 rounded-full bg-slate-300"></div> BINANCE
            </div>
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-transparent text-[10px] font-bold <?= $status_inactive ?>">
                <div class="w-1.5 h-1.5 rounded-full bg-slate-300"></div> BYBIT
            </div>
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-transparent text-[10px] font-bold <?= $status_inactive ?>">
                <div class="w-1.5 h-1.5 rounded-full bg-slate-300"></div> OKX
            </div>
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-transparent text-[10px] font-bold <?= $status_inactive ?>">
                <div class="w-1.5 h-1.5 rounded-full bg-slate-300"></div> KUCOIN
            </div>
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-transparent text-[10px] font-bold <?= $status_inactive ?>">
                <div class="w-1.5 h-1.5 rounded-full bg-slate-300"></div> TOKOCRYPTO
            </div>
        </div>

        <div class="flex items-center gap-4">
            <a href="portfolio.php" class="hidden md:flex items-center gap-2 bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-200">
                <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                RISK MGMT
            </a>

            <div class="h-8 w-[1px] bg-slate-200 hidden md:block"></div>

            <div class="flex items-center gap-3">
                <div class="text-right hidden md:block">
                    <div class="text-xs font-bold text-slate-700"><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></div>
                </div>
                <a href="logout.php" class="text-xs bg-slate-100 text-slate-600 px-3 py-2 rounded-lg font-bold hover:bg-red-50 hover:text-red-600 transition">Exit</a>
            </div>
        </div>
    </div>

    <div class="md:hidden flex gap-2 px-4 py-2 border-t border-slate-100 bg-slate-50 overflow-x-auto no-scrollbar">
        <a href="easy.php" class="px-3 py-1 rounded-full text-[10px] font-bold whitespace-nowrap <?= ($current_page == 'easy.php') ? 'bg-blue-100 text-blue-700' : 'bg-white text-slate-500 border border-slate-200' ?>">Easy Mode</a>
        <a href="pro.php" class="px-3 py-1 rounded-full text-[10px] font-bold whitespace-nowrap <?= ($current_page == 'pro.php') ? 'bg-blue-100 text-blue-700' : 'bg-white text-slate-500 border border-slate-200' ?>">Pro Mode</a>
        <a href="portfolio.php" class="px-3 py-1 rounded-full text-[10px] font-bold whitespace-nowrap bg-slate-900 text-yellow-400">Risk Mgmt</a>
    </div>
</nav>