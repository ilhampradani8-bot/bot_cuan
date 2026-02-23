<?php
// FILE: web_dashboard/portfolio.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio & Settings - TradingSafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 h-screen flex flex-col overflow-hidden font-sans">

    <?php require_once 'components/navbar.php'; ?>

    <div class="flex flex-1 overflow-hidden">
        
        <?php require_once 'components/sidebar.php'; ?>

        <main class="flex-1 overflow-y-auto p-6 bg-slate-50 relative">
            
            <button class="sidebar-toggle absolute top-4 left-4 bg-white p-2 rounded-lg shadow-md border border-slate-200 text-slate-500 hover:text-blue-600 hover:bg-slate-50 z-10 cursor-pointer transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                </svg>
            </button>

            <div class="max-w-6xl mx-auto pl-10">
                <h1 class="text-2xl font-bold text-slate-800 mb-1">Portfolio Overview</h1>
                <p class="text-xs text-slate-500 mb-6">Pantau alokasi aset dan performa bot Anda secara real-time.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                        <div class="text-xs font-bold text-slate-400 uppercase mb-2">Total Estimated Balance</div>
                        <div class="text-3xl font-bold text-slate-800">Rp 14.500.000</div>
                        <div class="text-xs text-green-500 font-bold mt-2">+2.4% (24h)</div>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                        <div class="text-xs font-bold text-slate-400 uppercase mb-2">Active Trading Pairs</div>
                        <div class="text-3xl font-bold text-slate-800">5 <span class="text-sm text-slate-400">/ 10</span></div>
                        <div class="text-xs text-blue-500 font-bold mt-2">Mesin Rust Berjalan Normal</div>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                        <div class="text-xs font-bold text-slate-400 uppercase mb-2">Win Rate (30 Hari)</div>
                        <div class="text-3xl font-bold text-slate-800">76%</div>
                        <div class="text-xs text-slate-500 font-bold mt-2">Berdasarkan 42 transaksi</div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50">
                        <h3 class="font-bold text-slate-800 text-sm">Asset Allocation (Indodax)</h3>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 text-[10px] text-slate-400 uppercase tracking-wider">
                                    <th class="p-4 border-b border-slate-100 font-bold">Aset</th>
                                    <th class="p-4 border-b border-slate-100 font-bold text-right">Saldo</th>
                                    <th class="p-4 border-b border-slate-100 font-bold text-right">Nilai (IDR)</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs font-bold text-slate-700">
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-4 border-b border-slate-100 flex items-center gap-3">
                                        <span class="w-2 h-2 rounded-full bg-orange-500"></span> BTC
                                    </td>
                                    <td class="p-4 border-b border-slate-100 text-right">0.0051</td>
                                    <td class="p-4 border-b border-slate-100 text-right">Rp 5.732.000</td>
                                </tr>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-4 border-b border-slate-100 flex items-center gap-3">
                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> ETH
                                    </td>
                                    <td class="p-4 border-b border-slate-100 text-right">0.1200</td>
                                    <td class="p-4 border-b border-slate-100 text-right">Rp 3.944.000</td>
                                </tr>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-4 border-b border-slate-100 flex items-center gap-3">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span> IDR (Cash)
                                    </td>
                                    <td class="p-4 border-b border-slate-100 text-right">Rp 4.824.000</td>
                                    <td class="p-4 border-b border-slate-100 text-right">Rp 4.824.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>