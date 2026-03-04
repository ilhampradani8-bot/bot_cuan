<?php
// FILE: web_dashboard/stop_impersonating.php
// Mengakhiri sesi impersonasi dan kembali ke login admin.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hancurkan sesi user yang sedang di-impersonate
session_unset();
session_destroy();

// Arahkan kembali ke halaman login admin
header("Location: admin/index.php");
exit;
?>
