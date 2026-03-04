<?php
// FILE: web_dashboard/admin/pages/faq.php
// Konten untuk halaman manajemen FAQ.
?>
<header class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-slate-900">FAQ Management</h1>
    <button id="add-faq-modal-btn" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">
        <i class="fa-solid fa-plus"></i> Tambah FAQ
    </button>
</header>
    
<div id="faq-list-container" class="grid gap-4">
    <!-- Konten FAQ akan dimuat di sini oleh JavaScript -->
    <p class="text-slate-500 animate-pulse">Memuat daftar FAQ...</p>
</div>
