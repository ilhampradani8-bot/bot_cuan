<?php
// FILE: web_dashboard/admin/pages/overview.php
// Konten untuk halaman dashboard overview.
?>
<header class="mb-8">
    <h1 class="text-3xl font-bold leading-tight text-slate-900">Dashboard Overview</h1>
    <p class="text-sm text-slate-500">A real-time summary of your platform's vital signs.</p>
</header>

<div id="dashboard-content" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Card 1: Total Users -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-5">
        <div class="w-12 h-12 flex items-center justify-center bg-blue-100 rounded-xl"><i class="fa-solid fa-users text-2xl text-blue-600"></i></div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Users</p>
            <p id="total-users-stat" class="text-3xl font-extrabold text-slate-800 animate-pulse">...</p>
        </div>
    </div>
    <!-- Card 2: Active Bots -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-5">
        <div class="w-12 h-12 flex items-center justify-center bg-green-100 rounded-xl"><i class="fa-solid fa-robot text-2xl text-green-600"></i></div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Bots</p>
            <p id="active-bots-stat" class="text-3xl font-extrabold text-slate-800 animate-pulse">...</p>
        </div>
    </div>
    <!-- Card 3: Trading Volume -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-5">
        <div class="w-12 h-12 flex items-center justify-center bg-amber-100 rounded-xl"><i class="fa-solid fa-chart-line text-2xl text-amber-600"></i></div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Volume (IDR)</p>
            <p id="trading-volume-stat" class="text-3xl font-extrabold text-slate-800 animate-pulse">...</p>
        </div>
    </div>
    <!-- Card 4: System Health -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">System Health</p>
            <i class="fa-solid fa-server text-xl text-slate-400"></i>
        </div>
        <div id="system-health-stat" class="space-y-2 animate-pulse">
            <p class="text-xs font-semibold text-slate-600">Checking...</p>
            <p class="text-xs font-semibold text-slate-600">Checking...</p>
            <p class="text-xs font-semibold text-slate-600">Checking...</p>
        </div>
    </div>
</div>
