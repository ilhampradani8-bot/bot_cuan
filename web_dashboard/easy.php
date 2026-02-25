<?php
// =================================================================================
// 1. PHP LOGIC BLOCK
// =================================================================================
session_start();
require_once 'components/database.php';

// A. Cek Login & Ambil User ID
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$user_id = $_SESSION['user_id'];

// B. Inisialisasi variabel default
$is_expired = true;
$days_left = 0;
$is_verified = 0;
$is_pending_payment = false;
// Tambahkan setting baru ke array default
$bot_settings = [
    'pair' => 'BTC/IDR', 
    'target_profit' => '1.5', 
    'stop_loss' => '2', 
    'api_key' => '', 
    'secret_key' => '',
    'is_active' => 0,
    'use_fixed_profit' => 0,
    'use_auto_pilot' => 0
];

try {
    // C. Ambil Data Profil User
    $stmtUser = $pdo->prepare("SELECT expired_at, is_verified FROM users WHERE id = ?");
    $stmtUser->execute([$user_id]);
    $userProfile = $stmtUser->fetch(PDO::FETCH_ASSOC);
    $is_verified = $userProfile['is_verified'] ?? 0;

    // D. Cek Status Langganan (Subscription)
    if ($userProfile && $userProfile['expired_at']) {
        $now = new DateTime();
        $expiry = new DateTime($userProfile['expired_at']);
        if ($expiry > $now) {
            $is_expired = false;
            $days_left = $now->diff($expiry)->days;
        }
    }

    // E. Cek jika ada pembayaran pending (untuk user expired)
    if ($is_expired) {
        $stmtTrx = $pdo->prepare("SELECT id FROM transactions WHERE user_id = ? AND status = 'pending' ORDER BY id DESC LIMIT 1");
        $stmtTrx->execute([$user_id]);
        if ($stmtTrx->fetch()) {
            $is_pending_payment = true;
        }
    }

    // F. Ambil Pengaturan Bot dari Database
    $stmtBot = $pdo->prepare("SELECT * FROM bot_settings WHERE user_id = ?");
    $stmtBot->execute([$user_id]);
    $saved_settings = $stmtBot->fetch(PDO::FETCH_ASSOC);
    if ($saved_settings) {
        // Gabungkan pengaturan dari DB dengan default, agar key baru tetap ada
        $bot_settings = array_merge($bot_settings, $saved_settings);
    }

} catch (Exception $e) {
    // Handle database error if necessary
}

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
        /* Custom Toggle Switch CSS */
        .switch{position:relative;display:inline-block;width:50px;height:28px}.switch input{opacity:0;width:0;height:0}.slider{position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background-color:#ccc;transition:.4s;border-radius:28px}.slider:before{position:absolute;content:"";height:20px;width:20px;left:4px;bottom:4px;background-color:#fff;transition:.4s;border-radius:50%}input:checked+.slider{background-color:#2563eb}input:checked+.slider:before{transform:translateX(22px)}
    </style>
</head>
<body class="bg-slate-50 min-h-screen pb-20">

    <?php require_once 'components/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 space-y-6 mt-6">
        
        <!-- Bagian Banner Status (Verifikasi, Expired, dll) -->
        <!-- ======================================================================== -->
<!-- Bagian Banner Status (Verifikasi, Expired, dll)                      -->
<!-- ======================================================================== -->
<section id="status-banners" class="space-y-4">
    <?php if (empty($bot_settings['api_key']) && !$is_expired): ?>
    <div id="api-key-warning" class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg shadow-sm flex items-center gap-4">
        <span class="text-2xl">🔑</span>
        <div>
            <h4 class="text-sm font-bold text-yellow-900">API Key Belum Terpasang</h4>
            <p class="text-xs text-yellow-800">Bot tidak akan berjalan tanpa API Key. Harap pasang di pengaturan.</p>
        </div>
        <a href="settings.php" class="ml-auto bg-yellow-600 text-white px-4 py-1.5 rounded text-xs font-bold">Pengaturan</a>
    </div>
    <?php endif; ?>

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


        <!-- ======================================================================== -->
        <!-- PANEL KONTROL BARU                                                     -->
        <!-- ======================================================================== -->
        <section id="bot-control-panel" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="font-bold text-slate-800 mb-6">🕹️ Bot Control</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- 1. Fixed Profit Target Toggle -->
                <div class="flex items-center justify-between p-3 border rounded-xl">
                    <div>
                        <p class="font-bold text-sm text-slate-700">Fixed Profit Target</p>
                        <p class="text-xs text-slate-500">Jual otomatis saat profit tercapai.</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" onchange="saveSingleSetting('use_fixed_profit', this.checked)" <?= !empty($bot_settings['use_fixed_profit']) ? 'checked' : '' ?>>
                        <span class="slider"></span>
                    </label>
                </div>
                <!-- 2. Auto Pilot Sniper Toggle -->
                <div class="flex items-center justify-between p-3 border rounded-xl">
                    <div>
                        <p class="font-bold text-sm text-slate-700">Auto Pilot Sniper</p>
                        <p class="text-xs text-slate-500">Bot cari & eksekusi koin baru.</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" onchange="saveSingleSetting('use_auto_pilot', this.checked)" <?= !empty($bot_settings['use_auto_pilot']) ? 'checked' : '' ?>>
                        <span class="slider"></span>
                    </label>
                </div>
                <!-- 3. Anti Panic Shield Button -->
                <div class="flex items-center justify-between p-3 border border-red-200 bg-red-50 rounded-xl">
                     <div>
                        <p class="font-bold text-sm text-red-700">Anti Panic Shield</p>
                        <p class="text-xs text-red-500">Jual semua aset di pair ini.</p>
                    </div>
                    <button onclick="saveSingleSetting('panic_sell', 1)" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 font-bold text-xs">CLOSE ALL</button>
                </div>
            </div>
        </section>
        
        <!-- Panel Pengaturan Strategi & Terminal -->
        <!-- ======================================================================== -->
<!-- Panel Pengaturan Strategi & Terminal                                   -->
<!-- ======================================================================== -->
<!-- Panel Pengaturan Strategi & Chart                                      -->
<!-- ======================================================================== -->
<!-- ======================================================================== -->
<!-- Panel Pengaturan Strategi & Chart                                      -->
<!-- ======================================================================== -->
<section class="grid md:grid-cols-2 gap-6">
    <!-- Kartu Form Pengaturan Bot -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="font-bold text-slate-800 mb-6">⚙️ Pengaturan Strategi</h3>
        <form id="bot-form" class="space-y-4">

            <!-- Mode Pair Selection -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Mode Target</label>
                <div class="flex gap-2">
                    <button type="button" id="manual-mode-btn" class="w-full p-3 rounded-xl text-sm font-bold border-2 border-blue-500 bg-blue-50 text-blue-700">Manual</button>
                    <button type="button" id="auto-mode-btn" class="w-full p-3 rounded-xl text-sm font-bold border-2 border-slate-200 bg-slate-50 text-slate-500">Auto-Detect</button>
                </div>
            </div>

            <!-- [MODIFIED] Manual Target Selection Section -->
                        <!-- [MODIFIED] Manual Target Selection Section -->
            <div id="manual-pair-section">
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Target Koin</label>
                <div id="pair-inputs" class="space-y-2">
                    <?php
                    // Explode the saved pairs string into an array.
                    $saved_pairs = !empty($bot_settings['pair']) ? explode(',', $bot_settings['pair']) : [];
                    
                    // If there are no saved pairs, create one empty input to start with.
                    if (empty($saved_pairs)) {
                        $saved_pairs[] = '';
                    }

                    foreach ($saved_pairs as $index => $pair):
                    ?>
                    <div class="flex items-center gap-2">
                        <select name="pairs[]" class="coin-select w-full border border-slate-200 rounded-xl p-3 text-sm font-bold uppercase bg-white appearance-none">
                            <!-- JS will populate this. We pre-select the saved value. -->
                            <option value="<?= htmlspecialchars($pair) ?>" selected><?= htmlspecialchars(empty($pair) ? 'Pilih Koin...' : $pair) ?></option>
                        </select>
                        
                        <?php if ($index === 0): // Show '+' on the first line ?>
                            <button type="button" onclick="addPairInput()" class="bg-blue-500 text-white rounded-full w-8 h-8 flex-shrink-0 flex items-center justify-center font-bold text-xl">+</button>
                        <?php else: // Show '-' on subsequent lines ?>
                            <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white rounded-full w-8 h-8 flex-shrink-0 flex items-center justify-center font-bold">-</button>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            
            <!-- Auto-Detect Info Panel -->
            <div id="auto-detect-info" class="hidden">
                 <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <h4 class="text-sm font-bold text-blue-900">Mode Auto-Detect Aktif</h4>
                    <p class="text-xs text-blue-800 mt-1">Bot akan secara otomatis memindai dan memilih koin dari market.</p>
                </div>
            </div>

            <!-- Profit and Stop Loss Inputs -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Profit %</label>
                    <input type="number" id="target_profit" value="<?= htmlspecialchars($bot_settings['target_profit']) ?>" placeholder="1.5" step="0.1" class="w-full border border-slate-200 rounded-xl p-3 text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Stop Loss %</label>
                    <input type="number" id="stop_loss" value="<?= htmlspecialchars($bot_settings['stop_loss']) ?>" placeholder="2.0" step="0.1" class="w-full border border-slate-200 rounded-xl p-3 text-sm">
                </div>
            </div>

            <!-- Action Buttons -->
            <?php if ($is_expired): ?>
                <div class="flex gap-2">
                     <button type="button" onclick="saveStrategy(1, true)" class="w-1/2 bg-blue-600 text-white py-3 rounded-xl font-bold text-xs hover:bg-blue-700">▶️ JALANKAN SIMULASI</button>
                     <button type="button" onclick="saveStrategy()" class="w-1/2 bg-white border border-slate-200 text-slate-600 py-3 rounded-xl font-bold text-xs">💾 SIMPAN</button>
                </div>
            <?php else: ?>
                 <div class="flex gap-2">
                    <button type="button" onclick="saveStrategy(0)" class="w-1/3 bg-white border border-slate-200 text-slate-600 py-3 rounded-xl font-bold text-xs">🛑 STOP</button>
                    <button type="button" onclick="saveStrategy(1)" class="w-2/3 bg-slate-900 text-white py-3 rounded-xl font-bold text-xs hover:bg-slate-800">🚀 START ENGINE</button>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <!-- Real-time Chart -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col">
         <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-slate-800">📊 Live Chart</h3>
            <span id="chart-status" class="text-xs font-bold text-slate-400">Menyambungkan...</span>
        </div>
        <div id="tv-chart-container" class="w-full h-full min-h-[300px] bg-white"></div>
    </div>
</section>




    </main>
    
<!-- Include Lightweight Charts library -->
<script src="assets/js/chart.js"></script>

<!-- ======================================================================== -->
<!-- JAVASCRIPT LOGIC (ADAPTED FROM PRO MODE FOR RELIABILITY)               -->
<!-- ======================================================================== -->
<script>
// ===================================================================
// 1. GLOBAL STATE & CACHE
// ===================================================================
const API_KEY_SET = <?= json_encode(!empty($bot_settings['api_key'])) ?>;
let pairMode = 'manual';
// Global cache for the coin list to avoid multiple API calls.
let coinListData = []; 

// ===================================================================
// 2. CHART SYSTEM (Grafik Real-time)
// ===================================================================
let chartObj = null;
let candleSeries = null;

function initChart() {
    const container = document.getElementById('tv-chart-container');
    if (!container || typeof LightweightCharts === 'undefined') {
        console.error("Chart container or Library not found!");
        return;
    }
    try {
        chartObj = LightweightCharts.createChart(container, {
            width: container.clientWidth, height: 350,
            layout: { background: { color: '#ffffff' }, textColor: '#333' },
            timeScale: { timeVisible: true, secondsVisible: false },
        });

        // [FIX] Add fallback for different library versions
        try {
            // Modern/correct method
            candleSeries = chartObj.addCandlestickSeries({
                upColor: '#26a69a', downColor: '#ef5350', borderVisible: false,
                wickUpColor: '#26a69a', wickDownColor: '#ef5350',
            });
        } catch (e) {
            console.warn("Using fallback for chart series initialization.");
            // Fallback for older or slightly different library versions
            candleSeries = chartObj.addSeries(LightweightCharts.CandlestickSeries);
        }

        // Initial data load and set interval for updates
        loadChartData();
        setInterval(loadChartData, 5000);

    } catch (err) {
        console.error("Chart initialization failed:", err);
    }
}


async function loadChartData() {
    if (!candleSeries) return;
    // Use the value from the *first* dropdown as the chart's main pair
    const firstPairInput = document.querySelector('select[name="pairs[]"]');
    if (!firstPairInput || !firstPairInput.value) return;
    
    const pair = firstPairInput.value.toLowerCase().replace('/', '_');
    const statusEl = document.getElementById('chart-status');
    statusEl.textContent = 'Memuat...';

    try {
        const res = await fetch(`api/chart_data.php?pair=${pair}`);
        const json = await res.json();
        if (json.status === 'success' && json.data.length > 0) {
            candleSeries.setData(json.data);
            chartObj.timeScale().fitContent();
            statusEl.textContent = `Live: ${pair.toUpperCase()}`;
            statusEl.className = 'text-xs font-bold text-green-600';
        } else {
             statusEl.textContent = 'Data Kosong';
             statusEl.className = 'text-xs font-bold text-orange-500';
        }
    } catch (e) {
        statusEl.textContent = 'Gagal Memuat';
        statusEl.className = 'text-xs font-bold text-red-500';
        console.error("Chart data failed to load:", e);
    }
}

// ===================================================================
// 3. COIN/PAIR SELECTION LOGIC (Logika Pilihan Koin)
// ===================================================================

/**
 * Fetches the master list of all available coins from the local API.
 * This runs only once and stores the result in the `coinListData` cache.
 */
async function fetchMasterCoinList() {
    if (coinListData.length > 0) return Promise.resolve(); // Use cache if available

    try {
        // [FIX] Using the same reliable API as Pro Mode
        const response = await fetch('api/get_indodax_pairs.php'); 
        
        if (!response.ok) {
            // Throw an error if the HTTP response is not 2xx
            throw new Error(`API request failed with status ${response.status}`);
        }

        const json = await response.json();
        
        // Check if the response from the API is successful and contains data
        if ((json.status === 'success' || json.status === 'fallback') && Array.isArray(json.data)) {
            // [FIX] Adapt to the data structure of get_indodax_pairs.php, which is {id, name}
            // We take the 'id' (e.g., "btc_idr") and format it to "BTC/IDR"
            coinListData = json.data.map(coin => coin.id.replace('_', '/').toUpperCase());
            console.log("Master coin list loaded successfully via get_indodax_pairs.php");
        } else {
            // Handle cases where the JSON is valid but indicates an error
            throw new Error(json.message || "Invalid data format from API.");
        }
    } catch (e) {
        // This will now catch network errors, HTTP errors, and JSON parsing/validation errors
        console.error("CRITICAL: Could not load master coin list. " + e.message);
    }
}


/**
 * Populates a single <select> dropdown element with options from the cached list.
 * @param {HTMLElement} selectElement - The <select> element to populate.
 */
function populateSelectWithOptions(selectElement) {
    if (!selectElement || coinListData.length === 0) return;

    const currentValue = selectElement.value; // Preserve the currently selected value.
    selectElement.innerHTML = '<option value="" disabled>--- Pilih Koin ---</option>'; // Add a placeholder.

    coinListData.forEach(coinPair => {
        const option = document.createElement('option');
        option.value = coinPair;
        option.textContent = coinPair;
        // If this coin was the one previously selected, re-select it.
        if (coinPair === currentValue) {
            option.selected = true;
        }
        selectElement.appendChild(option);
    });
}

/**
 * Creates and adds a new dropdown for selecting an additional coin.
 * This is called when the '+' button is clicked.
 */
function addPairInput() {
    const container = document.getElementById('pair-inputs');
    if (!container) return;

    const newPairWrapper = document.createElement('div');
    newPairWrapper.className = 'flex items-center gap-2';

    // Create the new <select> element
    const newSelect = document.createElement('select');
    newSelect.name = 'pairs[]';
    newSelect.className = 'coin-select w-full border border-slate-200 rounded-xl p-3 text-sm font-bold uppercase bg-white appearance-none';
    
    // Create the remove ('-') button
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.onclick = function() { this.parentElement.remove(); };
    removeBtn.className = 'bg-red-500 text-white rounded-full w-8 h-8 flex-shrink-0 flex items-center justify-center font-bold';
    removeBtn.textContent = '-';

    // Append new elements to the DOM
    newPairWrapper.appendChild(newSelect);
    newPairWrapper.appendChild(removeBtn);
    container.appendChild(newPairWrapper);

    // Immediately populate the new dropdown with the cached coin list.
    populateSelectWithOptions(newSelect);
}

// ===================================================================
// 4. FORM SAVING LOGIC (Logika Simpan Pengaturan)
// ===================================================================

async function saveStrategy(isActive, isSimulation = false) {
    if (isActive === 1 && !isSimulation && !API_KEY_SET) {
        alert("🚨 API Key Belum Terpasang! Silakan pasang di halaman Pengaturan.");
        return;
    }

    const btn = event.target;
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    // Query for all selected pairs from all dropdowns.
    const pairInputs = document.querySelectorAll('select[name="pairs[]"]');
    const pairs = Array.from(pairInputs).map(input => input.value).filter(v => v); // Filter out empty selections.

    const data = {
        target_profit: document.getElementById('target_profit').value,
        stop_loss: document.getElementById('stop_loss').value,
    };
    
    // Determine which mode is active and set data accordingly.
    if (pairMode === 'manual') {
        data.pair = pairs.join(','); // Join multiple pairs with a comma.
        data.use_auto_detect = 0;
    } else {
        data.pair = ''; // Clear pairs if in auto mode.
        data.use_auto_detect = 1;
    }
    
    // Only include 'is_active' if a start/stop button was pressed.
    if (isActive !== undefined) {
        data.is_active = isActive;
    }

    try {
        const response = await fetch('api/save_config.php', { 
            method: 'POST', 
            headers: { 'Content-Type': 'application/json' }, 
            body: JSON.stringify(data) 
        });
        if (!response.ok) throw new Error('Respon server tidak baik.');
        alert("✅ Pengaturan berhasil disimpan!");
        // Reload the page if the bot was started or stopped to reflect status.
        if (isActive !== undefined) {
            setTimeout(() => location.reload(), 500);
        }
    } catch (e) { 
        alert("❌ Gagal menyimpan pengaturan: " + e.message); 
    } finally {
        // Restore button state
        btn.disabled = false;
        // Restore original button text based on what was clicked
        if (isActive === 1) btn.textContent = '🚀 START ENGINE';
        else if (isActive === 0) btn.textContent = '🛑 STOP';
        else btn.textContent = '💾 SIMPAN';
    }
}

async function saveSingleSetting(key, value) {
    let finalValue = (typeof value === 'boolean') ? (value ? 1 : 0) : value;
    try {
        await fetch('api/save_config.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ [key]: finalValue })
        });
        // Optionally, add a small visual indicator for success.
    } catch (e) { 
        alert('❌ Gagal menyimpan setting: ' + e.message); 
    }
}

// ===================================================================
// 5. INITIALIZATION (Fungsi yang Dijalankan Saat Halaman Dimuat)
// ===================================================================
document.addEventListener('DOMContentLoaded', async () => {
    
    // --- Step 1: Fetch the master coin list first. ---
    // The 'await' ensures that the coin list is ready before we do anything else.
    await fetchMasterCoinList();

    // --- Step 2: Now that the list is cached, populate all existing dropdowns. ---
    document.querySelectorAll('.coin-select').forEach(selectElement => {
        populateSelectWithOptions(selectElement);
    });
    
    // --- Step 3: Initialize the chart. ---
    initChart();

    // --- Step 4: Set up UI event listeners. ---

    // Accordion FAQ Logic
    document.querySelectorAll('.faq-item').forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const arrow = item.querySelector('.faq-arrow');

        question.addEventListener('click', () => {
            const isHidden = answer.classList.contains('hidden');
            answer.classList.toggle('hidden', !isHidden);
            arrow.classList.toggle('rotate-180', isHidden);
        });
    });

    // Mode toggle button listeners
    const manualBtn = document.getElementById('manual-mode-btn');
    const autoBtn = document.getElementById('auto-mode-btn');
    const manualSection = document.getElementById('manual-pair-section');
    const autoInfo = document.getElementById('auto-detect-info');
    
    manualBtn.addEventListener('click', () => {
        pairMode = 'manual';
        manualSection.style.display = 'block';
        autoInfo.style.display = 'none';
        manualBtn.className = 'w-full p-3 rounded-xl text-sm font-bold border-2 border-blue-500 bg-blue-50 text-blue-700';
        autoBtn.className = 'w-full p-3 rounded-xl text-sm font-bold border-2 border-slate-200 bg-slate-50 text-slate-500';
    });
    
    autoBtn.addEventListener('click', () => {
        pairMode = 'auto';
        manualSection.style.display = 'none';
        autoInfo.style.display = 'block';
        autoBtn.className = 'w-full p-3 rounded-xl text-sm font-bold border-2 border-blue-500 bg-blue-50 text-blue-700';
        manualBtn.className = 'w-full p-3 rounded-xl text-sm font-bold border-2 border-slate-200 bg-slate-50 text-slate-500';
    });
});
</script>


</body>
</html>
