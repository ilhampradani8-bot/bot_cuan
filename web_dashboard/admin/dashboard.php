<?php
// FILE: web_dashboard/admin/dashboard.php
// File ini bertindak sebagai "router" untuk menampilkan konten halaman yang benar.

// 1. Muat header (dari direktori yang sama)
// Header ini sudah berisi pemeriksaan sesi, jadi halaman ini aman.
require_once __DIR__ . '/header.php';

// 2. Tentukan halaman mana yang akan ditampilkan
// Ambil parameter 'page' dari URL, jika tidak ada, default ke 'users'.
$page_to_load = $_GET['page'] ?? 'users';

// 3. Bangun path file yang akan di-include
$page_file_path = __DIR__ . '/pages/' . $page_to_load . '.php';

// 4. Logika untuk memuat file halaman
// Periksa apakah file halaman yang diminta benar-benar ada.
if (file_exists($page_file_path)) {
    // Jika ada, muat file halamannya.
    include_once $page_file_path;
} else {
    // Jika tidak ada (misal: ?page=halamantidakada), tampilkan pesan error 404.
    echo '
    <div class="text-center">
        <h1 class="text-6xl font-bold text-red-500">404</h1>
        <p class="text-xl text-slate-700 mt-4">Halaman tidak ditemukan.</p>
        <p class="text-slate-500">Halaman yang Anda minta (`' . htmlspecialchars($page_to_load) . '`) tidak ada.</p>
    </div>';
}

// 5. Muat footer (dari direktori yang sama)
// Footer ini berisi semua logika JavaScript.
require_once __DIR__ . '/footer.php';

?>
