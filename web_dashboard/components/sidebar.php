<?php
// ===================================================================
// COMPONENT: MAIN SIDEBAR NAVIGATION
// ===================================================================
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside id="sidebar" class="w-64 bg-white border-r border-slate-200 flex flex-col absolute md:relative h-full z-40 transition-all duration-300">
    
    <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Main Menu</span>
        <button class="sidebar-toggle text-slate-400 hover:text-red-500 cursor-pointer p-1 rounded-md hover:bg-slate-200 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto p-4 space-y-1">
        
        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 mt-2">Workspaces</div>
        <a href="easy.php" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors <?= $current_page == 'easy.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' ?>">
            <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            Easy Mode
        </a>
        <a href="pro.php" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors <?= $current_page == 'pro.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' ?>">
            <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            Pro Mode
        </a>
        
        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 mt-6">Finance</div>
        <a href="portfolio.php" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors <?= $current_page == 'portfolio.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' ?>">
            <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Portfolio
        </a>
        <a href="pembukuan.php" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors <?= $current_page == 'pembukuan.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' ?>">
            <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
            Pembukuan
        </a>
        <a href="laporan.php" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors <?= $current_page == 'laporan.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' ?>">
            <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Laporan
        </a>
        
        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 mt-6">System</div>
<a href="api_keys.php" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors <?= $current_page == 'api_keys.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' ?>">
    <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
    API Keys Management
</a>
        <a href="settings.php" class="flex items-center gap-3 px-3 py-2.5 text-xs font-bold rounded-lg transition-colors <?= $current_page == 'settings.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' ?>">
            <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Pengaturan Tambahan
        </a>
    </nav>
</aside>

<script>
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const toggles = document.querySelectorAll('.sidebar-toggle');
        
        let isClickInside = sidebar.contains(event.target);
        let isToggleClick = Array.from(toggles).some(btn => btn.contains(event.target));

        // Logic 1: Jika klik tombol toggle (burger), buka/tutup sidebar
        if (isToggleClick) {
            sidebar.classList.toggle('-ml-64');
            return;
        }

        // Logic 2: Auto-hide jika user klik area LUAR sidebar saat sidebar sedang terbuka
        if (!isClickInside && !sidebar.classList.contains('-ml-64')) {
            sidebar.classList.add('-ml-64');
        }
    });
</script>