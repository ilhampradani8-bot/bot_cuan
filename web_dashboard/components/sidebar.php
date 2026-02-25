<?php
// FILE: web_dashboard/components/sidebar.php
// VERSI FINAL - Logika hide/show ada di dalam file ini sendiri.

$current_page = basename($_SERVER['PHP_SELF']);

$menu_items = [ 'portfolio.php' => ['icon' => 'fa-solid fa-chart-pie', 'label' => 'Dashboard'], 'easy_mode.php' => ['icon' => 'fa-solid fa-bolt', 'label' => 'Easy'], 'pro_mode.php' => ['icon' => 'fa-solid fa-rocket', 'label' => 'Pro'], 'chart.php' => ['icon' => 'fa-solid fa-chart-line', 'label' => 'Live Chart'], ];
$bottom_menu_items = [ 'pengaturan_api.php' => ['icon' => 'fa-solid fa-key', 'label' => 'Pengaturan API'], 'tutorial.php' => ['icon' => 'fa-solid fa-book-open', 'label' => 'Tutorial'], 'logout.php' => ['icon' => 'fa-solid fa-right-from-bracket', 'label' => 'Keluar'] ];
?>

<!-- DIUBAH: Posisi di bawah navbar (top-16), tanpa logo -->
<aside id="sidebar" class="fixed left-0 top-16 w-64 h-[calc(100vh-4rem)] bg-white border-r border-slate-200 flex flex-col z-30 transition-all duration-300">
    <nav class="flex-1 px-4 py-4 space-y-2">
        <?php foreach ($menu_items as $url => $item): ?>
            <a href="<?php echo $url; ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors <?php echo ($current_page == $url) ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100'; ?>">
                <i class="<?php echo $item['icon']; ?> w-5 text-center"></i>
                <span class="font-semibold sidebar-label"><?php echo $item['label']; ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="px-4 py-4 border-t border-slate-200">
        <nav class="space-y-2">
             <?php foreach ($bottom_menu_items as $url => $item): ?>
                <a href="<?php echo $url; ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors <?php echo ($current_page == $url) ? 'bg-slate-100 text-blue-700' : 'text-slate-600 hover:bg-slate-100'; ?>">
                    <i class="<?php echo $item['icon']; ?> w-5 text-center"></i>
                    <span class="font-semibold sidebar-label"><?php echo $item['label']; ?></span>
                </a>
            <?php endforeach; ?>
        </nav>
        
        <!-- BARU: Tombol untuk hide/show -->
        <button id="sidebar-hide-toggle" class="flex items-center gap-3 w-full px-4 py-2.5 mt-2 rounded-lg text-slate-600 hover:bg-slate-100">
            <i id="sidebar-hide-icon" class="fas fa-chevron-left w-5 text-center"></i>
            <span class="font-semibold sidebar-label">Sembunyikan</span>
        </button>
    </div>
</aside>

<!-- BARU: Script khusus untuk sidebar, ada di dalam file ini -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleButton = document.getElementById('sidebar-hide-toggle');
    const toggleIcon = document.getElementById('sidebar-hide-icon');
    const labels = document.querySelectorAll('.sidebar-label');

    if (toggleButton) {
        toggleButton.addEventListener('click', () => {
            // Cek kondisi saat ini
            const isCollapsed = sidebar.classList.contains('w-20');

            if (isCollapsed) {
                // Expand
                sidebar.classList.replace('w-20', 'w-64');
                if (mainContent) mainContent.classList.replace('md:ml-20', 'md:ml-64');
                toggleIcon.classList.replace('fa-chevron-right', 'fa-chevron-left');
                labels.forEach(label => label.classList.remove('hidden'));
            } else {
                // Collapse
                sidebar.classList.replace('w-64', 'w-20');
                if (mainContent) mainContent.classList.replace('md:ml-64', 'md:ml-20');
                toggleIcon.classList.replace('fa-chevron-left', 'fa-chevron-right');
                labels.forEach(label => label.classList.add('hidden'));
            }
        });
    }
});
</script>
