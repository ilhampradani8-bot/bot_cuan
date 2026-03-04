<?php
// FILE: web_dashboard/admin/pages/strategy.php
// Halaman untuk manajemen profit, fee, dan maintenance mode.
?>
<header class="mb-8">
    <h1 class="text-3xl font-bold leading-tight text-slate-900">Manajemen Strategi & Profit</h1>
    <p class="mt-1 text-slate-600">Kontrol parameter global platform, monitor profit, dan kelola status sistem.</p>
</header>

<div class="space-y-8">

    <!-- 1. Global PnL Tracker -->
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
        <h2 class="text-lg font-bold text-slate-800 flex items-center">
            <i class="fa-solid fa-coins text-yellow-500 mr-3"></i>
            Global Profit & Loss Tracker
        </h2>
        <p class="text-sm text-slate-500 mt-1">Total profit yang dihasilkan oleh semua bot pengguna.</p>
        <div id="global-pnl-container" class="mt-4 text-center py-4 bg-slate-50 rounded-xl animate-pulse">
            <p id="global-pnl-stat" class="text-4xl font-extrabold text-green-600">Memuat...</p>
        </div>
    </div>

    <!-- 2. Pengaturan Global -->
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
        <h2 class="text-lg font-bold text-slate-800 flex items-center">
            <i class="fa-solid fa-cogs text-slate-500 mr-3"></i>
            Pengaturan Global
        </h2>
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Fee Management -->
            <div class="space-y-2">
                <h3 class="font-semibold text-slate-700">Fee Management (Bagi Hasil)</h3>
                <p class="text-sm text-slate-500 pb-2">Atur persentase keuntungan yang akan diambil sebagai fee platform.</p>
                <div class="flex items-center">
                    <input type="number" id="admin-fee-input" class="w-32 px-4 py-2 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="cth: 5">
                    <span class="ml-3 text-slate-600 font-semibold">%</span>
                </div>
            </div>

            <!-- Maintenance Mode -->
            <div class="space-y-2">
                <h3 class="font-semibold text-slate-700">Maintenance Mode</h3>
                 <p class="text-sm text-slate-500 pb-2">Aktifkan untuk menonaktifkan semua aktivitas trading bot sementara.</p>
                <label for="maintenance-mode-toggle" class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" id="maintenance-mode-toggle" class="sr-only">
                        <div class="block bg-slate-200 w-14 h-8 rounded-full transition-all"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-all"></div>
                    </div>
                    <div id="maintenance-status-text" class="ml-3 text-slate-600 font-semibold">...</div>
                </label>
            </div>
        </div>
        <div class="mt-8 border-t border-slate-200 pt-6 flex justify-end">
             <button id="save-settings-btn" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all disabled:bg-slate-400 disabled:shadow-none">
                <i class="fa-solid fa-save mr-2"></i>Simpan Perubahan
            </button>
        </div>
    </div>
</div>

<!-- Styling untuk Toggle Switch -->
<style>
    input:checked ~ .dot {
        transform: translateX(100%);
        background-color: #3b82f6; /* bg-blue-500 */
    }
    input:checked ~ .block {
        background-color: #dbeafe; /* bg-blue-100 */
    }
</style>
