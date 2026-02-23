<?php
// ===================================================================
// NAVBAR: LANDING PAGE (INDEX)
// ===================================================================
// Check user session status to toggle UI buttons
$is_logged_in = isset($_SESSION['user_id']);
?>

<nav class="sticky top-0 bg-slate-900 px-6 py-4 border-b border-slate-800 flex justify-between items-center z-50 shadow-md">
    <a href="index.php" class="font-bold text-white text-xl tracking-tight">
        Trading<span class="text-blue-500">Safe</span>
    </a>
    
    <div class="flex items-center gap-3">
        <?php if ($is_logged_in): ?>
            <span class="text-xs text-slate-400 font-medium hidden sm:inline-block">Welcome back!</span>
            <a href="web_dashboard/pro.php" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-lg shadow-blue-900/50 transition-all">
                DASHBOARD
            </a>
        <?php else: ?>
            <a href="web_dashboard/login.php" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold rounded-lg border border-slate-700 transition-all">
                LOGIN
            </a>
            <a href="web_dashboard/register.php" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-lg shadow-blue-900/50 transition-all">
                REGISTER
            </a>
        <?php endif; ?>
    </div>
</nav>