<?php
// Start the session to check for login status
session_start();

// Security: Redirect any non-logged-in user to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial - TradingSafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">

    <?php 
    // Include the standard navigation bar component
    require_once './components/navbar.php'; 
    ?>

    <!-- Main content area for the tutorial page -->
    <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 mt-16">
        <!-- Page Header -->
        <header class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-slate-900">Dokumentasi & Tutorial</h1>
            <p class="mt-2 text-lg text-slate-600">Pelajari cara memaksimalkan bot trading Anda dengan panduan berikut.</p>
        </header>

        <!-- Tutorial Sections -->
        <div class="space-y-8">
            <section class="bg-white p-8 rounded-xl shadow-md border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-800">1. Menghubungkan Akun Exchange</h2>
                <p class="mt-4 text-slate-600 leading-relaxed">
                    Langkah pertama adalah menghubungkan akun exchange (Bybit, Binance, dll.) Anda ke sistem kami menggunakan API Key. Pastikan Anda telah menonaktifkan izin penarikan (withdrawal) pada API Key Anda demi keamanan. Cukup salin API Key dan Secret Key dari exchange Anda dan tempelkan di halaman <a href="dashboard.php" class="text-blue-600 font-semibold hover:underline">Dashboard</a>.
                </p>
            </section>

            <section class="bg-white p-8 rounded-xl shadow-md border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-800">2. Mode Pengaturan: Mudah vs Lanjutan</h2>
                <p class="mt-4 text-slate-600 leading-relaxed">
                    Kami menyediakan dua mode. Mode <code class="bg-slate-100 text-sm font-mono p-1 rounded">Mudah</code> untuk pengaturan cepat dengan parameter yang sudah dioptimalkan. Mode <code class="bg-slate-100 text-sm font-mono p-1 rounded">Lanjutan</code> memberikan Anda kontrol penuh atas setiap aspek strategi trading, cocok untuk pengguna berpengalaman.
                </p>
            </section>
            
             <section class="bg-white p-8 rounded-xl shadow-md border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-800">3. Memahami Notifikasi Telegram</h2>
                <p class="mt-4 text-slate-600 leading-relaxed">
                    Bot akan mengirimkan notifikasi real-time ke akun Telegram Anda untuk setiap aksi yang diambil, termasuk order beli, jual, dan status take profit / stop loss. Ini memastikan Anda selalu tahu apa yang sedang dilakukan bot Anda.
                </p>
            </section>
        </div>
    </main>

</body>
</html>
