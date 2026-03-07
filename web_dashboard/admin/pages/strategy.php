<?php
// FILE: web_dashboard/admin/pages/strategy.php
// Halaman untuk manajemen profit, fee, dan maintenance mode, dengan card yang bisa di-collapse.
?>
<header class="mb-8">
    <h1 class="text-3xl font-bold leading-tight text-slate-900">Manajemen Strategi & Profit</h1>
    <p class="mt-1 text-slate-600">Kontrol parameter global platform, monitor profit, dan kelola status sistem.</p>
</header>

<div class="space-y-8">

    <!-- 1. Global PnL Tracker (Collapsible) -->
    <div x-data="{ collapsed: false }" class="bg-white rounded-2xl shadow-lg border border-slate-200 transition-all">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <!-- Header Info -->
                <div>
                    <h2 class="text-lg font-bold text-slate-800 flex items-center">
                        <i class="fa-solid fa-coins text-yellow-500 mr-3"></i>
                        Global Profit & Loss Tracker
                    </h2>
                    <p x-show="!collapsed" class="text-sm text-slate-500 mt-1 transition-all">Total profit yang dihasilkan oleh semua bot pengguna.</p>
                </div>
                <!-- Toggle Button -->
                <button @click="collapsed = !collapsed" class="p-2 rounded-full hover:bg-slate-100 flex-shrink-0 ml-4">
                    <i class="fa-solid text-slate-500" :class="collapsed ? 'fa-chevron-right' : 'fa-chevron-left'"></i>
                </button>
            </div>
            <!-- Collapsible Body -->
            <div x-show="!collapsed" x-transition class="mt-4">
                <div id="global-pnl-container" class="text-center py-4 bg-slate-50 rounded-xl animate-pulse">
                    <p id="global-pnl-stat" class="text-4xl font-extrabold text-green-600">Memuat...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Pengaturan Global (Collapsible) -->
    <div x-data="{ collapsed: false }" class="bg-white rounded-2xl shadow-lg border border-slate-200 transition-all">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <!-- Header Info -->
                <div>
                    <h2 class="text-lg font-bold text-slate-800 flex items-center">
                        <i class="fa-solid fa-cogs text-slate-500 mr-3"></i>
                        Pengaturan Global
                    </h2>
                </div>
                <!-- Toggle Button -->
                <button @click="collapsed = !collapsed" class="p-2 rounded-full hover:bg-slate-100 flex-shrink-0 ml-4">
                    <i class="fa-solid text-slate-500" :class="collapsed ? 'fa-chevron-right' : 'fa-chevron-left'"></i>
                </button>
            </div>
            <!-- Collapsible Body -->
            <div x-show="!collapsed" x-transition class="mt-2">
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
    </div>

</div>

<!-- 3. Riwayat Transaksi Langganan (Collapsible) -->
<div x-data="{ collapsed: false }" class="bg-white rounded-2xl shadow-lg border border-slate-200/80 transition-all mt-8">
    <div class="p-6">
        <div class="flex justify-between items-start">
            <!-- Header Info -->
            <div>
                 <h3 class="text-xl font-bold text-slate-800">Riwayat Transaksi Langganan</h3>
            </div>
            <!-- Toggle Button -->
            <button @click="collapsed = !collapsed" class="p-2 rounded-full hover:bg-slate-100 flex-shrink-0 ml-4">
                <i class="fa-solid text-slate-500" :class="collapsed ? 'fa-chevron-right' : 'fa-chevron-left'"></i>
            </button>
        </div>
        <!-- Collapsible Body -->
        <div x-show="!collapsed" x-transition class="mt-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Kolom Kiri: Stat/Total -->
                <div class="lg:col-span-1">
                    <div class="bg-blue-50 border border-blue-200/50 rounded-xl p-5 text-center h-full flex flex-col justify-center">
                        <p class="text-sm font-bold uppercase text-blue-500">Transaksi Pending</p>
                        <p id="total-pending-transactions" class="text-5xl font-bold text-blue-700 mt-2 animate-pulse">...</p>
                        <p class="text-sm text-blue-600 mt-1">Menunggu verifikasi Anda</p>
                    </div>
                </div>
                
                <!-- Kolom Kanan: Daftar Transaksi -->
                <div class="lg:col-span-2">
                    <div id="transaction-list-container" class="space-y-3 max-h-80 overflow-y-auto pr-2">
                        <!-- Daftar transaksi akan dimuat di sini oleh JavaScript -->
                        <div class="text-center text-slate-400 animate-pulse pt-16">
                            <i class="fa-solid fa-spinner fa-spin text-2xl"></i>
                            <p class="mt-2">Memuat riwayat transaksi...</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>


<!-- Styling untuk Toggle Switch (Maintenance Mode) -->
<style>
    input:checked ~ .dot {
        transform: translateX(100%);
        background-color: #3b82f6; /* bg-blue-500 */
    }
    input:checked ~ .block {
        background-color: #dbeafe; /* bg-blue-100 */
    }
</style>
