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

            <div class="p-5 border-b border-slate-100">
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-3">Asset Category</label>
                <div class="grid grid-cols-2 gap-2">
                    <?php 
                    $cats = ['BIG'=>'Big Cap', 'MICIN'=>'Micin', 'TOP'=>'Top Vol', 'MANUAL'=>'Manual'];
                    foreach($cats as $val=>$label): 
                        $checked = ($cur_cat == $val) ? 'checked' : '';
                    ?>
                    <label class="cursor-pointer group">
                        <input type="radio" name="coin_cat" value="<?= $val ?>" class="peer hidden" <?= $checked ?> onchange="autoSave()">
                        <div class="border border-slate-200 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 rounded-lg py-3 text-center text-[10px] font-bold"><?= $label ?></div>
                    </label>
                    <?php endforeach; ?>
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
            <div class="bg-slate-50 px-5 py-4 border-b border-slate-200">
                <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">3. Live Scanner</h3>
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
window.calculatePnL = function() {
    const elModal = document.getElementById('calc_capital');
    const elTarget = document.getElementById('target_percent'); 
    const elOut = document.getElementById('out_net');

    if (!elModal || !elTarget || !elOut) return;

    const modal = parseFloat(elModal.value) || 0;
    const target = parseFloat(elTarget.value) || 0;
    const net = (modal * (target / 100)) - (modal * 0.006); // Fee Indodax

    elOut.innerText = "Rp " + Math.round(net).toLocaleString('id-ID');
    elOut.className = net > 0 ? "font-bold text-green-600" : "font-bold text-red-500";
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
    }
}

// 3. LOAD DATA REAL
async function loadChartData() {
    if (!candleSeries) return;
    try {
        const res = await fetch('api/chart_data.php?pair=btc_idr');
        const json = await res.json();
        if (json.status === 'success' && json.data.length > 0) {
            candleSeries.setData(json.data);
            chartObj.timeScale().fitContent();
        }
    } catch (e) { console.log("Menunggu data Rust..."); }
}

// EKSEKUSI
document.addEventListener('DOMContentLoaded', () => {
    // Jalankan kalkulator dulu agar ReferenceError hilang
    window.calculatePnL();
    
    // Beri jeda sedikit untuk library
    setTimeout(initChart, 300);
});

// ===================================================================
// FUNGSI SCANNER (MENAMPILKAN DATA DARI DB MARKET)
// ===================================================================
async function fetchMarket() {
    const tbody = document.getElementById('market-tbody');
    const pulse = document.getElementById('market-pulse');
    if (!tbody) return;

    try {
        // Ambil data dari API scanner yang sudah kita buat tadi
        const res = await fetch('api/market_scanner.php');
        const json = await res.json();

        if (json.status === 'success' && json.data.length > 0) {
            let html = '';
            json.data.forEach(coin => {
                // Styling warna harga sederhana
                const pairName = coin.pair.replace('_', '/').toUpperCase();
                
                html += `
                <tr class="hover:bg-slate-50 transition-colors cursor-pointer border-l-2 border-transparent hover:border-blue-500">
                    <td class="p-3 pl-5 font-bold text-slate-700">${pairName}</td>
                    <td class="p-3 text-right font-mono text-slate-600 font-bold">
                        Rp ${Math.round(coin.close).toLocaleString('id-ID')}
                    </td>
                    <td class="p-3 pr-5 text-right text-slate-400 font-mono">
                        ${(coin.volume / 1000000).toFixed(1)}M
                    </td>
                </tr>`;
            });
            
            tbody.innerHTML = html;
            
            // Efek berkedip hijau saat data masuk
            if (pulse) {
                pulse.classList.replace('bg-slate-300', 'bg-green-500');
                setTimeout(() => pulse.classList.replace('bg-green-500', 'bg-slate-300'), 500);
            }
        }
    } catch (e) {
        console.error("Scanner Error:", e);
    }
}

// Tambahkan pemanggilan ini di dalam document.addEventListener('DOMContentLoaded')
// agar tabel langsung terisi saat halaman dibuka.

    </script>
</body>
</html>