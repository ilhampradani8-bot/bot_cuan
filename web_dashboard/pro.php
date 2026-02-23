<?php 
// =================================================================================
// 1. PHP LOGIC (DATA FETCHING)
// =================================================================================
session_start();
require_once 'components/database.php';

// Cek Login
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$user_id = $_SESSION['user_id'];

// Ambil Settingan PRO dari Database
$stmt = $pdo->prepare("SELECT * FROM bot_settings WHERE user_id = ?");
$stmt->execute([$user_id]);
$config = $stmt->fetch(PDO::FETCH_ASSOC);

// Default Values
$cur_cat   = $config['coin_category'] ?? 'BIG';
$cur_strat = $config['strategy_type'] ?? 'dynamic';
$cur_pct   = $config['target_profit'] ?? 2.5;
$cur_fund  = $config['use_fundamental'] ?? 0;
$cur_ind   = json_decode($config['indicators'] ?? '[]', true); 
if (!is_array($cur_ind)) $cur_ind = [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pro Mode - TradingSafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-slate-50 h-screen flex flex-col overflow-hidden">

    <?php require_once 'components/navbar.php'; ?>

    <section id="main-pro-grid" class="flex-1 grid grid-cols-12 divide-x divide-slate-200 overflow-hidden">
        
        <aside id="section-config" class="col-span-12 lg:col-span-3 bg-white flex flex-col overflow-y-auto scrollbar-hide shadow-xl z-20">
    <div class="bg-slate-50 px-5 py-4 border-b border-slate-200 sticky top-0 z-10 flex justify-between items-center">
        <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">1. Strategy Center</h3>
        <span id="save-indicator" class="text-[9px] font-bold text-slate-400 uppercase">Auto-Save ON</span>
    </div>

    <div class="p-5 border-b border-slate-100" id="block-asset-category">
        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-3">Asset Category</label>
        <div class="grid grid-cols-2 gap-2">
            <?php 
            $cats = [
                'BIG' => 'Auto Big Cap', 
                'MICIN' => 'Auto Micin', 
                'TOP' => 'Auto Top Vol', 
                'MANUAL' => 'Manual Set'
            ];
            foreach($cats as $val => $label): 
                $checked = ($cur_cat == $val) ? 'checked' : '';
            ?>
            <label class="cursor-pointer group">
                <input type="radio" name="coin_cat" value="<?= $val ?>" class="peer hidden" <?= $checked ?> onchange="window.toggleManualUI(); autoSave();">
                <div class="border border-slate-200 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 rounded-lg py-3 text-center text-[10px] font-bold transition-all"><?= $label ?></div>
            </label>
            <?php endforeach; ?>
        </div>

        <div id="manual-coin-ui" class="mt-4 hidden flex-col gap-2">
            <label class="block text-[9px] font-bold text-slate-400 uppercase">Pilih Koin (Indodax API)</label>
            <div class="flex gap-2">
                <select id="indodax-coin-list" class="flex-1 bg-slate-50 border border-slate-200 rounded-lg p-2 text-xs font-bold outline-none">
                    <option value="">Memuat koin Indodax...</option>
                </select>
                <button type="button" onclick="window.addManualCoin()" class="bg-blue-600 text-white rounded-lg px-3 py-2 text-xs font-bold hover:bg-blue-700 transition-colors shadow-md">[+]</button>
            </div>
            <div id="selected-coins-container" class="flex flex-wrap gap-1 mt-2"></div>
        </div>
    </div>

    <div class="p-5 border-b border-slate-100 space-y-4">
        <label class="block text-[10px] font-bold text-slate-400 uppercase">Execution Logic</label>
        <select id="strategy_type" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-xs font-bold outline-none" onchange="autoSave()">
            <option value="dynamic" <?= $cur_strat=='dynamic'?'selected':'' ?>>Trailing Stop</option>
            <option value="simple" <?= $cur_strat=='simple'?'selected':'' ?>>Fixed Scalping</option>
        </select>
        <div>
            <label class="block text-[9px] text-slate-400 uppercase mb-1">Target Gain (%)</label>
            <input type="number" id="target_percent" step="0.1" value="<?= $cur_pct ?>" class="w-full bg-slate-50 border border-slate-200 rounded-lg p-2.5 text-right font-mono font-bold outline-none" onchange="autoSave()">
        </div>
    </div>

    <div class="p-5">
        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-3">Signal Triggers</label>
        <?php 
        $inds = ['rsi'=>'RSI < 30', 'macd'=>'MACD Cross', 'vol'=>'Volume Spike'];
        foreach($inds as $key=>$text): 
            $checked = in_array($key, $cur_ind) ? 'checked' : '';
        ?>
        <label class="flex items-center gap-3 cursor-pointer p-2 -mx-2 rounded hover:bg-slate-50 transition-colors">
            <input type="checkbox" name="indicators" value="<?= $key ?>" class="accent-blue-600 w-4 h-4" <?= $checked ?> onchange="autoSave()">
            <span class="text-xs text-slate-700 font-bold"><?= $text ?></span>
        </label>
        <?php endforeach; ?>
    </div>
</aside>
        <aside id="section-interactive" class="col-span-12 lg:col-span-5 flex flex-col bg-white overflow-hidden relative">
            <div id="block-chart" class="flex flex-col border-b border-slate-200 h-3/5 relative group">
                <div class="bg-white px-5 py-3 border-b border-slate-100 flex justify-between items-center z-10">
                    <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Market Live Chart</h3>
                    <button type="button" onclick="loadChartData()" class="text-blue-600 font-bold text-[9px] uppercase">Sync DB</button>
                </div>
                <div id="tv-chart-container" class="w-full h-full bg-white"></div>
            </div>

            <div id="block-calculator" class="p-5 border-b border-slate-200 bg-slate-50/50">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Modal Awal (IDR)</label>
                        <input type="number" id="calc_capital" value="1000000" class="w-full border border-slate-200 rounded p-2 text-xs font-mono font-bold outline-none" oninput="calculatePnL()">
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] text-slate-400 uppercase">Est. Net Profit</span>
                        <div id="out_net" class="font-bold text-green-600 text-sm">Rp 0</div>
                    </div>
                </div>
            </div>

            <div id="block-logs" class="flex-grow bg-slate-900 text-slate-400 p-4 font-mono text-[10px] overflow-y-auto">
                <div id="log-stream" class="space-y-1"></div>
            </div>
        </aside>

       <aside id="section-market" class="col-span-12 lg:col-span-4 bg-white flex flex-col border-l border-slate-200">
    <div class="bg-slate-50 px-5 py-4 border-b border-slate-200 flex justify-between items-center">
        <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">3. Live Scanner</h3>
        <div class="flex items-center gap-2">
            <div id="market-pulse" class="w-2 h-2 rounded-full bg-slate-300 transition-colors duration-500"></div>
            <span class="text-[9px] font-bold text-slate-500 uppercase">DB Feed</span>
        </div>
    </div>
    <div class="flex-grow overflow-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-white sticky top-0 z-10 text-slate-400 text-[9px] font-bold uppercase border-b border-slate-100">
                <tr><th class="p-3 pl-5">Pair</th><th class="p-3 text-right">Last Price</th><th class="p-3 pr-5 text-right">Vol</th></tr>
            </thead>
            <tbody id="market-tbody" class="divide-y divide-slate-50 text-[10px]">
            </tbody>
        </table>
    </div>
</aside>

    </section>

    <script src="assets/js/chart.js"></script>
    <script>
    // ===================================================================
// 1. GLOBAL SCOPE: KALKULATOR (Wajib Global agar HTML bisa baca)
// ===================================================================
// 1. GLOBAL CALCULATOR (Satu-satunya sumber kebenaran)
// ===================================================================
// FUNGSI: KALKULATOR PROFIT (Anti NaN)
// ===================================================================
window.calculatePnL = function() {
    const elModal = document.getElementById('calc_capital');
    const elTarget = document.getElementById('target_percent'); 
    const elOut = document.getElementById('out_net');

    if (!elModal || !elTarget || !elOut) return;

    // Paksa jadi angka. Kalau kosong/error, otomatis jadi 0
    const modal = parseFloat(elModal.value) || 0;
    const target = parseFloat(elTarget.value) || 0;
    
    const net = (modal * (target / 100)) - (modal * 0.006); // Potong fee 0.6%

    // Cek lagi untuk memastikan hasil bukan NaN
    const finalNet = isNaN(net) ? 0 : Math.round(net);

    elOut.innerText = "Rp " + finalNet.toLocaleString('id-ID');
    elOut.className = finalNet > 0 ? "font-bold text-green-500 text-sm" : "font-bold text-red-500 text-sm";
};

// 2. CHART SYSTEM
let chartObj = null;
let candleSeries = null;

function initChart() {
    const container = document.getElementById('tv-chart-container');
    if (!container) return;

    // DIAGNOSA: Cek apakah ini benar library TradingView?
    if (typeof LightweightCharts === 'undefined') {
        console.error("ALARM: Library TradingView tidak terdeteksi! Cek file assets/js/chart.js Mas.");
        return;
    }

    try {
        chartObj = LightweightCharts.createChart(container, {
            width: container.clientWidth,
            height: 350,
            layout: { background: { color: '#ffffff' }, textColor: '#333' },
            timeScale: { timeVisible: true },
        });

        // GUNAKAN METODE PALING STABIL [cite: 2026-02-18]
        // Jika .addCandlestickSeries gagal, coba .addSeries
        try {
            candleSeries = chartObj.addCandlestickSeries({
                upColor: '#26a69a', downColor: '#ef5350'
            });
        } catch (e) {
            console.warn("Mencoba metode fallback addSeries...");
            candleSeries = chartObj.addSeries(LightweightCharts.CandlestickSeries);
        }

        loadChartData();
    } catch (err) {
        console.error("Gagal total init chart:", err);
        addLog("TradingView Engine Ready", "SUCCESS");
    }

    
}

// 3. LOAD DATA REAL
// ===================================================================
// FUNGSI: LOAD DATA REAL (Dengan Realtime Logging)
// ===================================================================
async function loadChartData() {
    if (!candleSeries) return; // Exit if series not ready
    try {
        const res = await fetch('api/chart_data.php?pair=btc_idr'); // Fetch data from API
        const json = await res.json(); // Parse JSON response
        
        if (json.status === 'success' && json.data.length > 0) {
            candleSeries.setData(json.data); // Update chart with new data
            chartObj.timeScale().fitContent(); // Auto-fit chart view
            
            // --- LOGGING DATA REALTIME ---
            const latest = json.data[json.data.length - 1]; // Get the newest candle data
            const formatPrice = latest.close.toLocaleString('id-ID'); // Format price to IDR
            addLog(`Chart Feed: BTC/IDR | Close: Rp ${formatPrice}`, "SUCCESS"); // Send to terminal
        }
    } catch (e) { 
        addLog("Sync Chart: Menunggu data dari Rust...", "INFO"); // Log waiting status
    }
}

// EKSEKUSI

// ===================================================================
// EKSEKUSI (DOM READY)
// ===================================================================
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(window.toggleManualUI, 500);
    // 1. Jalankan kalkulator dulu agar ReferenceError hilang
    window.calculatePnL();
    
    // 2. Beri jeda sedikit untuk inisialisasi library grafik
    setTimeout(initChart, 300);

    // 3. JALANKAN SCANNER PASAR
    fetchMarket(); // Panggil pertama kali agar tabel langsung terisi
    setInterval(fetchMarket, 10000); // Update harga di tabel setiap 10 detik
});

// ===================================================================
// FUNGSI SCANNER (MENAMPILKAN DATA DARI DB MARKET)
// ===================================================================

// ===================================================================
// FUNGSI: PRINTER LOG (Terminal Gelap)
// ===================================================================
function addLog(msg, type = "INFO") {
    const stream = document.getElementById('log-stream');
    if (!stream) return;
    
    const time = new Date().toLocaleTimeString('id-ID');
    
    // Set warna kontras terang untuk background gelap
    let color = "text-slate-300"; // Default: Putih terang untuk INFO
    if (type === "SUCCESS") color = "text-green-400";
    if (type === "ERR") color = "text-red-400";
    
    stream.innerHTML += `<div class="border-b border-slate-700/50 py-1.5 flex gap-2">
        <span class="text-slate-400 font-bold">[${time}]</span>
        <span class="${color}">${msg}</span>
    </div>`;
    
    // Auto-scroll ke paling bawah setiap ada log baru
    stream.scrollTop = stream.scrollHeight; 
}

// ===================================================================
// FUNGSI: SCANNER (Anti NaN)
// ===================================================================
// ===================================================================
// FUNGSI: SCANNER (Dengan Realtime Logging)
// ===================================================================
async function fetchMarket() {
    const tbody = document.getElementById('market-tbody'); // Get table body element
    if (!tbody) return; // Exit if table not found

    try {
        const res = await fetch('api/market_scanner.php'); // Fetch scanner data
        const json = await res.json(); // Parse JSON response

        if (json.status === 'success' && json.data) {
            let html = ''; // Init empty HTML string
            let pairsSynced = []; // Init array for log summary
            
            json.data.forEach(coin => {
                const price = parseFloat(coin.close) || 0; // Safe parse price
                const vol = parseFloat(coin.volume) || 0; // Safe parse volume
                
                pairsSynced.push(coin.pair.toUpperCase()); // Track synced pairs
                
                html += `
                <tr class="hover:bg-slate-50 transition-colors cursor-pointer border-l-2 border-transparent hover:border-blue-500">
                    <td class="p-3 pl-5 font-bold text-slate-700">${coin.pair.toUpperCase()}</td>
                    <td class="p-3 text-right font-mono font-bold text-slate-600">
                        Rp ${Math.round(price).toLocaleString('id-ID')}
                    </td>
                    <td class="p-3 pr-5 text-right text-slate-400 font-mono">
                        ${(vol / 1000000).toFixed(1)}M
                    </td>
                </tr>`; // Append table row
            });
            tbody.innerHTML = html; // Inject HTML to table
            
            // --- LOGGING DATA REALTIME ---
            addLog(`Scanner Feed: Synced [${pairsSynced.join(', ')}]`, "INFO"); // Send summary to terminal
        }
    } catch (e) { 
        addLog(`Scanner Error: ${e.message}`, "ERR"); // Send error to terminal
    }
}


// ===================================================================
// FUNGSI: MANUAL COIN SELECTOR (Indodax API)
// ===================================================================
window.selectedManualCoins = []; // Array to store selected coins

// Show/Hide Manual UI based on selected radio button
window.toggleManualUI = function() {
    const cat = document.querySelector('input[name="coin_cat"]:checked').value;
    const ui = document.getElementById('manual-coin-ui');
    
    if (cat === 'MANUAL') {
        ui.classList.remove('hidden'); // Show UI
        ui.classList.add('flex');
        
        // Fetch coins only if the list is empty
        const select = document.getElementById('indodax-coin-list');
        if (select.options.length <= 1) {
            window.fetchIndodaxCoins(); 
        }
    } else {
        ui.classList.add('hidden'); // Hide UI
        ui.classList.remove('flex');
    }
};

// Fetch all pairs directly from Indodax Public API
// ===================================================================
// FUNGSI: MENGAMBIL LIST KOIN DARI BACKEND LOKAL (Bypass CORS)
// ===================================================================
window.fetchIndodaxCoins = async function() {
    const select = document.getElementById('indodax-coin-list');
    
    try {
        // Ambil data dari API buatan Mas sendiri, BUKAN dari URL Indodax
        const res = await fetch('api/get_indodax_pairs.php'); 
        const json = await res.json();
        
        if (json.status === 'success' || json.status === 'fallback') {
            select.innerHTML = '<option value="">-- Pilih Koin --</option>';
            
            // Looping data yang sudah dirapikan oleh PHP
            json.data.forEach(coin => {
                select.innerHTML += `<option value="${coin.id}">${coin.name}</option>`;
            });
            
            if (typeof addLog === "function") {
                addLog("Daftar koin berhasil dimuat dari Backend", "SUCCESS");
            }
        } else {
            throw new Error("Format data salah");
        }
    } catch (e) {
        console.error("Gagal load list koin lokal:", e);
        select.innerHTML = '<option value="">Gagal muat data server!</option>';
        if (typeof addLog === "function") {
            addLog("Gagal memuat daftar koin manual", "ERR");
        }
    }
};

// Add selected coin to the badge list
window.addManualCoin = function() {
    const select = document.getElementById('indodax-coin-list');
    const val = select.value;

    if (!val) return; // Exit if empty
    if (window.selectedManualCoins.includes(val)) return; // Prevent duplicate coins

    window.selectedManualCoins.push(val); // Save to array
    window.renderManualCoins(); // Update UI
    
    addLog(`Menambahkan ${val.toUpperCase()} ke daftar manual`, "SUCCESS");
    // autoSave(); // Uncomment this later if you want to save the array to DB
};

// Remove coin from the badge list
window.removeManualCoin = function(val) {
    window.selectedManualCoins = window.selectedManualCoins.filter(c => c !== val);
    window.renderManualCoins();
    // autoSave(); 
};

// Draw the coin badges
window.renderManualCoins = function() {
    const container = document.getElementById('selected-coins-container');
    container.innerHTML = ''; // Clear container
    
    window.selectedManualCoins.forEach(val => {
        let pairName = val.toUpperCase().replace('_', '/');
        container.innerHTML += `
        <div class="bg-slate-800 text-slate-100 text-[10px] font-bold px-2 py-1.5 rounded flex items-center gap-2 shadow-sm border border-slate-700">
            ${pairName} 
            <span onclick="window.removeManualCoin('${val}')" class="text-red-400 hover:text-red-500 cursor-pointer text-xs leading-none">✖</span>
        </div>`;
    });
};

// Tambahkan pemanggilan ini di dalam document.addEventListener('DOMContentLoaded')
// agar tabel langsung terisi saat halaman dibuka.

    </script>
</body>
</html>