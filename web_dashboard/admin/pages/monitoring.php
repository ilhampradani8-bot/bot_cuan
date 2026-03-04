<?php
// FILE: web_dashboard/admin/pages/monitoring.php
if (!defined('IS_ADMIN_PAGE')) {
    die('Akses ditolak!');
}
?>

<div x-data="monitoringController()" x-init="init()" class="space-y-8">
    <h1 class="text-2xl font-bold text-slate-800">Server & Bot Monitoring</h1>

    <!-- System Stats -->
    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-slate-700 mb-6">System Health</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- CPU Usage -->
            <div class="bg-slate-50 p-6 rounded-lg">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-slate-700">CPU Load</h3>
                    <i class="fas fa-microchip text-slate-400 text-2xl"></i>
                </div>
                <template x-if="!loading">
                    <p class="text-3xl font-bold text-slate-900 mt-2" x-text="stats.cpu + '%'"></p>
                </template>
                <template x-if="loading"><div class="h-8 w-20 bg-slate-200 rounded animate-pulse mt-2"></div></template>
            </div>

            <!-- Memory Usage -->
            <div class="bg-slate-50 p-6 rounded-lg">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-slate-700">Memory</h3>
                    <i class="fas fa-memory text-slate-400 text-2xl"></i>
                </div>
                <template x-if="!loading && stats.memory && !stats.memory.error">
                    <div>
                        <p class="text-3xl font-bold text-slate-900 mt-2" x-text="stats.memory.used_formatted"></p>
                        <p class="text-sm text-slate-500" x-text="'Total: ' + stats.memory.total_formatted"></p>
                    </div>
                </template>
                <template x-if="loading"><div class="h-8 w-24 bg-slate-200 rounded animate-pulse mt-2"></div></template>
            </div>

            <!-- Disk Usage -->
            <div class="bg-slate-50 p-6 rounded-lg">
                 <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-slate-700">Disk Space</h3>
                    <i class="fas fa-hdd text-slate-400 text-2xl"></i>
                </div>
                <template x-if="!loading && stats.disk && !stats.disk.error">
                    <div>
                        <p class="text-3xl font-bold text-slate-900 mt-2" x-text="stats.disk.free_formatted + ' Free'"></p>
                        <p class="text-sm text-slate-500" x-text="'Total: ' + stats.disk.total_formatted"></p>
                    </div>
                </template>
                <template x-if="loading"><div class="h-8 w-28 bg-slate-200 rounded animate-pulse mt-2"></div></template>
            </div>
        </div>
    </div>
    
    <!-- Bot Status -->
    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-slate-700 mb-6">Bot Engines</h2>
        <div class="space-y-4">
            <template x-if="loading">
                <div class="h-12 bg-slate-200 rounded animate-pulse"></div>
            </template>
            <template x-if="!loading && stats.bots && stats.bots.length > 0">
                <template x-for="bot in stats.bots" :key="bot.name">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                        <span class="font-semibold text-slate-800" x-text="bot.name"></span>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm font-bold"
                                :class="{ 'text-green-600': bot.status === 'Running', 'text-red-600': bot.status === 'Stopped' }"
                                x-text="bot.status">
                            </span>
                             <span class="h-3 w-3 rounded-full"
                                :class="{ 'bg-green-500': bot.status === 'Running', 'bg-red-500': bot.status === 'Stopped' }">
                            </span>
                        </div>
                    </div>
                </template>
            </template>
             <template x-if="!loading && (!stats.bots || stats.bots.length === 0)">
                <p class="text-slate-500">No bots configured or found.</p>
             </template>
        </div>
    </div>
</div>

<script>
function monitoringController() {
    return {
        loading: true,
        stats: {
            cpu: 0,
            memory: { used_formatted: '0 MB', total_formatted: '0 GB' },
            disk: { free_formatted: '0 GB', total_formatted: '0 GB' },
            bots: []
        },
        error: null,
        
        init() {
            this.fetchStats();
            setInterval(() => this.fetchStats(), 5000);
        },
        
        fetchStats() {
            fetch('../api/get_server_stats.php')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok: ' + response.statusText);
                    return response.json();
                })
                .then(data => {
                    if (data.error) throw new Error('API Error: ' + data.error);
                    this.stats = data;
                    this.error = null;
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    this.error = error.message;
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
}
</script>
