<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>TradingSafe - Bot Trading Sniper Indodax Tercepat & Presisi</title>
    <meta name="description" content="Otomatisasi trading Indodax Anda dengan TradingSafe. Bot sniper berbasis Rust dengan eksekusi milidetik. Aman, mudah, dan profit maksimal.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="http://tradingsafe.com/">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
        .glass-nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); }
        .hero-gradient { background: radial-gradient(circle at 50% 50%, #f8fafc 0%, #e2e8f0 100%); }
    </style>
</head>
<body class="text-slate-900 bg-white">

<?php 
// Start session globally if not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php require_once 'web_dashboard/components/navbar_index.php'; ?>

<!-- ================================================================================= -->
<!-- 1. NEW HERO SECTION BLOCK (TEXT-ONLY) -->
<!-- Find and delete the existing hero <section>...</section> block. -->
<!-- Then, paste this new block in its place. -->
<!-- ================================================================================= -->
<section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 text-white overflow-hidden">
    <!-- Decorative background glows for visual depth, without an image. -->
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl opacity-50"></div>

    <!-- This is the main container, centering content vertically and horizontally. -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Using flexbox to center the content block in the available space. -->
        <div class="flex flex-col justify-center items-center min-h-[75vh] py-20 text-center">
            
            <!-- This container holds all the text content. -->
            <div>
                <!-- Main Headline: The primary message of the platform. -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-slate-100 to-slate-400">
                    Automated Trading,<br> Elevated Performance.
                </h1>
                <!-- Sub-headline: Provides more context and value proposition, centered with a max-width. -->
                <p class="mt-6 max-w-2xl mx-auto text-lg text-slate-300">
                    Manfaatkan kekuatan bot trading berkinerja tinggi yang dirancang untuk kecepatan, keamanan, dan presisi di pasar crypto.
                </p>

                <!-- Google Login Button: The primary call-to-action for users. -->
                <div class="mt-10">
                    <a href="web_dashboard/login.php" class="inline-flex items-center justify-center bg-white text-slate-800 font-bold py-3 px-6 rounded-lg shadow-lg hover:bg-slate-200 transition-colors duration-300">
                        <!-- Google Icon SVG for visual identity. -->
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571l6.19,5.238C42.022,35.244,44,30.036,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path></svg>
                        Login with Google
                    </a>
                </div>

                <!-- Key Statistics Section: Highlights key metrics and platform milestones. -->
                <div class="mt-16 grid grid-cols-2 sm:grid-cols-3 gap-8 text-center max-w-3xl mx-auto">
                    <div>
                        <p class="text-3xl font-bold text-white">60B+</p>
                        <p class="mt-1 text-xs text-slate-400 uppercase tracking-wider">Monthly Trading Volume</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white">6Y+</p>
                        <p class="mt-1 text-xs text-slate-400 uppercase tracking-wider">Has Offered Service For</p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-3xl font-bold text-white">5M+</p>
                        <p class="mt-1 text-xs text-slate-400 uppercase tracking-wider">Global Users</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ================================================================================= -->
<!-- 2. NEW FEATURES SECTION -->
<!-- Paste this entire block between the hero section and the footer. -->
<!-- ================================================================================= -->
<style>
    /* Custom CSS for the animated grid background and hiding the scrollbar */
    /* Keyframes for the grid movement animation */
    @keyframes moveGrid {
        from { background-position: 0 0; }
        to { background-position: 100px 50px; }
    }
    /* Class to apply the animated grid */
    .animated-grid-background {
        position: absolute; /* Takes it out of the normal document flow */
        inset: 0; /* Stretches it to cover the parent */
        width: 100%;
        height: 100%;
        background-image: 
            linear-gradient(to right, #e5e7eb 1px, transparent 1px), 
            linear-gradient(to bottom, #e5e7eb 1px, transparent 1px); /* Creates grid lines */
        background-size: 50px 50px; /* Size of the grid cells */
        mask-image: radial-gradient(ellipse 80% 50% at 50% 0%, black, transparent 70%); /* Fades out the grid */
        animation: moveGrid 5s linear infinite; /* Applies the movement animation */
        opacity: 0.5;
    }
    /* Utility to hide scrollbars on scrollable elements */
    .scrollbar-hide::-webkit-scrollbar { display: none; } /* For Chrome, Safari, and Opera */
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; } /* For IE/Edge and Firefox */
</style>

<section class="relative bg-white py-20 lg:py-24 overflow-hidden">
    <!-- The animated grid background div -->
    <div class="animated-grid-background"></div>
    
    <!-- Content container, positioned above the background grid -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header: Title and subtitle -->
        <div class="text-center max-w-3xl mx-auto">
            <h2 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">
                Dirancang untuk Setiap Level Trader
            </h2>
            <p class="mt-4 text-lg text-slate-600">
                Dari mode satu-klik yang simpel hingga kustomisasi penuh, temukan alat yang tepat untuk mendukung strategi trading Anda.
            </p>
        </div>

        <!-- Horizontal Scrollable Container for Feature Cards -->
        <div class="mt-16">
            <!-- This div enables horizontal scrolling with a gentle fading edge on the right -->
            <div class="relative">
                <div class="flex overflow-x-auto space-x-6 sm:space-x-8 pb-8 scrollbar-hide -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
                    
                    <!-- Feature Card 1: Easy Mode -->
                    <div class="flex-shrink-0 w-72 bg-white border border-slate-200 rounded-2xl shadow-lg p-6">
                        <h3 class="font-bold text-slate-800">Easy Mode</h3>
                        <p class="mt-2 text-sm text-slate-500">Mulai trading hanya dengan beberapa klik. Sempurna untuk pemula.</p>
                    </div>

                    <!-- Feature Card 2: Pro Mode -->
                    <div class="flex-shrink-0 w-72 bg-white border border-slate-200 rounded-2xl shadow-lg p-6">
                        <h3 class="font-bold text-slate-800">Pro Mode</h3>
                        <p class="mt-2 text-sm text-slate-500">Kontrol penuh atas setiap parameter bot untuk trader berpengalaman.</p>
                    </div>

                    <!-- Feature Card 3: Auto Pilot -->
                    <div class="flex-shrink-0 w-72 bg-white border border-slate-200 rounded-2xl shadow-lg p-6">
                        <h3 class="font-bold text-slate-800">Auto Pilot</h3>
                        <p class="mt-2 text-sm text-slate-500">Biarkan bot bekerja 24/7 menjalankan strategi Anda secara otomatis.</p>
                    </div>

                    <!-- Feature Card 4: Anti Panic -->
                    <div class="flex-shrink-0 w-72 bg-white border border-slate-200 rounded-2xl shadow-lg p-6">
                        <h3 class="font-bold text-slate-800">Anti Panic</h3>
                        <p class="mt-2 text-sm text-slate-500">Eksekusi Take Profit & Stop Loss otomatis untuk menghindari keputusan emosional.</p>
                    </div>

                    <!-- Feature Card 5: Trading Journal -->
                    <div class="flex-shrink-0 w-72 bg-white border border-slate-200 rounded-2xl shadow-lg p-6">
                        <h3 class="font-bold text-slate-800">Trading Journal</h3>
                        <p class="mt-2 text-sm text-slate-500">Semua transaksi tercatat rapi untuk analisis dan evaluasi performa.</p>
                    </div>

                    <!-- Feature Card 6: Custom Indicator -->
                    <div class="flex-shrink-0 w-72 bg-white border border-slate-200 rounded-2xl shadow-lg p-6">
                        <h3 class="font-bold text-slate-800">Custom Indicator</h3>
                        <p class="mt-2 text-sm text-slate-500">Gunakan indikator kustom Anda sendiri untuk sinyal trading yang unik.</p>
                    </div>

                    <!-- Feature Card 7: Trailing Stop -->
                    <div class="flex-shrink-0 w-72 bg-white border border-slate-200 rounded-2xl shadow-lg p-6">
                        <h3 class="font-bold text-slate-800">Trailing Stop</h3>
                        <p class="mt-2 text-sm text-slate-500">Amankan profit sambil memberi ruang bagi aset untuk terus naik.</p>
                    </div>

                </div>
                <!-- Fading gradient on the right to indicate more content -->
                <div class="absolute top-0 bottom-0 right-0 w-24 bg-gradient-to-l from-white pointer-events-none"></div>
            </div>
        </div>
    </div>
</section>


<!-- ================================================================================= -->
<!-- 3. NEW FUND SECURITY SECTION -->
<!-- Find and delete the old <section id="fitur">...</section> block. -->
<!-- Then, paste this new block in its place. -->
<!-- ================================================================================= -->
<section id="security" class="bg-white py-20 lg:py-24">
    <!-- Main container for the security section content. -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <!-- Titles to introduce the section's theme: security. -->
        <div class="text-center max-w-3xl mx-auto">
            <h2 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">
                Fund Security is Our Fundamental Principle
            </h2>
            <p class="mt-4 text-lg text-slate-600">
                Kami membangun platform ini di atas fondasi keamanan, kepatuhan, dan transparansi untuk melindungi aset Anda.
            </p>
        </div>

        <!-- Grid container for the three security pillars. -->
        <!-- It's a 3-column grid on large screens and a 1-column grid on smaller screens. -->
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">

            <!-- Pillar 1: Compliance Matrix -->
            <div class="text-center">
                <!-- Custom SVG icon for Compliance -->
                <div class="flex justify-center items-center mx-auto w-16 h-16 bg-slate-100 rounded-2xl">
                    <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286zm0 13.036h.008v.008h-.008v-.008z" /></svg>
                </div>
                <!-- Title for the pillar -->
                <h3 class="mt-6 text-xl font-bold text-slate-900">Compliance Matrix</h3>
                <!-- Description for the pillar, integrating project-specific details. -->
                <p class="mt-2 text-slate-600">
                    TradingSafe terdaftar melalui <strong>OSS</strong> dan dalam proses audit lisensi <strong>Bappebti & OJK</strong>. Infrastruktur kami mengacu pada standar <strong>ISO 27001</strong> dan <strong>SOC2 Type II</strong> untuk memastikan kepatuhan regulasi.
                </p>
            </div>

            <!-- Pillar 2: Account Security -->
            <div class="text-center">
                <!-- Custom SVG icon for Account Security -->
                <div class="flex justify-center items-center mx-auto w-16 h-16 bg-slate-100 rounded-2xl">
                    <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
                </div>
                <!-- Title for the pillar -->
                <h3 class="mt-6 text-xl font-bold text-slate-900">Account Security</h3>
                <!-- Description for the pillar, integrating project-specific details. -->
                <p class="mt-2 text-slate-600">
                    Dengan protokol <i>Non-Custodial</i>, API key Anda dienkripsi via <strong>AES-256</strong>. Kami mewajibkan penonaktifan fitur withdrawal pada API, Google Authenticator, dan whitelist untuk keamanan maksimal.
                </p>
            </div>
            
            <!-- Pillar 3: 100% Reserves -->
            <div class="text-center">
                <!-- Custom SVG icon for Reserves -->
                <div class="flex justify-center items-center mx-auto w-16 h-16 bg-slate-100 rounded-2xl">
                    <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375" /></svg>
                </div>
                <!-- Title for the pillar -->
                <h3 class="mt-6 text-xl font-bold text-slate-900">100% Reserves</h3>
                <!-- Description for the pillar -->
                <p class="mt-2 text-slate-600">
                    Aset pengguna disimpan terpisah dari dana operasional. Kami menjaga rasio cadangan 100% dan menggunakan audit 'Merkle Tree' untuk membuktikan transparansi dana kami.
                </p>
                <a href="#" class="mt-4 inline-block text-blue-600 font-bold hover:underline">Lihat Audit Keamanan</a>
            </div>

        </div>
    </div>
</section>


<!-- ================================================================================= -->
<!-- 4. ACCESSIBILITY SECTION (REVISED IMAGE PATH) -->
<!-- Find and delete the old <section id="anywhere">...</section> block. -->
<!-- Then, paste this new block in its place. -->
<!-- ================================================================================= -->
<section id="anywhere" class="bg-slate-50 py-20 lg:py-24 overflow-hidden">
    <!-- Main container for the section content. -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Responsive grid layout: 2 columns on large screens, 1 on small. -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <!-- Left Column: Image -->
            <!-- This column holds the visual representation of the app on multiple devices. -->
            <div class="relative">
                <!-- The main image is now loaded from the local project folder. -->
                <img src="en.5ba4f5a10ab4e5cf.png" 
                     alt="TradingSafe dashboard on phone and tablet" 
                     class="relative z-10 rounded-lg shadow-xl">
                
                <!-- Decorative background blob for visual flair. -->
                <div class="absolute -top-10 -left-10 w-80 h-80 bg-blue-200/50 rounded-full blur-3xl" aria-hidden="true"></div>
            </div>

            <!-- Right Column: Text Content & Call to Action -->
            <!-- This column explains the benefit of accessing the platform anywhere. -->
            <div class="text-center lg:text-left">
                <!-- Main headline for the section. -->
                <h2 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">
                    Trade Easily Anytime, Anywhere
                </h2>
                <!-- Descriptive paragraph. -->
                <p class="mt-4 text-lg text-slate-600">
                    Akses dashboard web TradingSafe yang responsif dari perangkat apa pun. Pantau pasar, kelola bot, dan analisis performa Anda dengan mudah, baik dari desktop di rumah maupun dari ponsel saat Anda bepergian.
                </p>
                
                <!-- List of key features related to accessibility. -->
                <ul class="mt-8 space-y-4 text-left inline-block">
                    <!-- Feature 1: Responsive Dashboard -->
                    <li class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-500 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="text-slate-700 font-medium">Dashboard Web Responsif</span>
                    </li>
                    <!-- Feature 2: 24/7 Cloud Access -->
                    <li class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-500 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="text-slate-700 font-medium">Akses 24/7 via Cloud</span>
                    </li>
                    <!-- Feature 3: No Installation Needed -->
                    <li class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-500 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="text-slate-700 font-medium">Tidak Perlu Instalasi</span>
                    </li>
                </ul>
                
                <!-- Call to action button -->
                <div class="mt-10">
                    <a href="web_dashboard/easy.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg shadow-blue-500/30 transition-all">
                        Buka Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="faq" class="py-24 bg-white border-t border-slate-100">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Pertanyaan Umum</h2>
            <p class="text-slate-500">Informasi lengkap mengenai legalitas, keamanan, dan operasional infrastruktur kami.</p>
        </div>

        <div class="space-y-6">
            
            <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition duration-300">
                <div class="flex items-start gap-4">
                    <div class="mt-1 text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04kM12 21.48l.307-.13c4.757-2.013 8.193-6.143 8.193-10.99 0-1.44-.265-2.822-.751-4.09l-.13-.306M12 21.48l-.307-.13C6.936 19.337 3.5 15.207 3.5 10.36c0-1.44.265-2.822.751-4.09l.13-.306"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 mb-2">Apakah TradingSafe sudah terdaftar secara resmi?</h4>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Secara korporasi, TradingSafe telah terdaftar resmi melalui sistem <strong>OSS (Online Single Submission)</strong> untuk izin operasional teknologi informasi. Terkait regulasi finansial, saat ini kami sedang dalam tahap audit mendalam untuk lisensi <strong>Bappebti</strong> dan <strong>OJK</strong>. Dikarenakan standar kepatuhan yang sangat tinggi, proses audit ini diperkirakan memakan waktu sekitar 1 tahun guna memastikan perlindungan maksimal bagi seluruh pengguna.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition duration-300">
                <div class="flex items-start gap-4">
                    <div class="mt-1 text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 mb-2">Bagaimana sistem menjamin keamanan API Key saya?</h4>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Kami menerapkan protokol keamanan <i>Non-Custodial</i>. Semua API Key dienkripsi menggunakan algoritma <strong>AES-256</strong> di tingkat database. Selain itu, kami mewajibkan pengguna untuk menonaktifkan fitur penarikan (withdrawal) pada pengaturan API Key, sehingga sistem hanya memiliki izin untuk eksekusi perdagangan secara terbatas.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition duration-300">
                <div class="flex items-start gap-4">
                    <div class="mt-1 text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 mb-2">Sertifikasi keamanan internasional apa yang digunakan?</h4>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Infrastruktur TradingSafe dikembangkan mengacu pada standar manajemen keamanan informasi <strong>ISO 27001</strong> dan kepatuhan <strong>SOC2 Type II</strong>. Kami melakukan audit internal secara berkala untuk memastikan integritas data dan ketersediaan layanan tetap berada pada level optimal.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-xl hover:shadow-slate-100 transition duration-300">
                <div class="flex items-start gap-4">
                    <div class="mt-1 text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 mb-2">Mengapa TradingSafe lebih cepat dari kompetitor?</h4>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Keunggulan utama kami terletak pada mesin inti yang dibangun menggunakan bahasa <strong>Rust</strong>. Teknologi ini memberikan performa setara dengan sistem di bursa saham global dan manajemen memori yang sangat aman, meminimalkan risiko <i>system crash</i> saat terjadi volatilitas pasar yang tinggi.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ================================================================================= -->
<!-- 2. NEW FOOTER BLOCK -->
<!-- Find and delete the existing <footer>...</footer> block. -->
<!-- Then, paste this new block in its place. -->
<!-- ================================================================================= -->
<footer class="bg-slate-900 text-slate-300 pt-20 pb-10">
    <!-- This is the main container for the footer content, centered with a max-width. -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Community Call-to-Action -->
        <!-- This section invites users to join the Telegram community for discussion. -->
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-white mb-4">Mari Berdiskusi dan Bertumbuh Bersama</h2>
            <p class="mb-6 text-slate-400 max-w-2xl mx-auto">Punya pertanyaan, butuh bantuan, atau ingin berbagi strategi? Komunitas kami adalah tempatnya.</p>
            <a href="https://t.me/+alUQbx_4tWZkYWY1" target="_blank" rel="noopener noreferrer" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg transition-colors duration-300 shadow-lg shadow-blue-500/20">
                Gabung ke Komunitas Kami di Telegram
            </a>
        </div>

        <!-- Footer Links Grid -->
        <!-- A responsive grid layout to organize all the footer links into logical columns. -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 text-sm">
            
            <!-- Column 1: About -->
            <!-- Contains links related to the company, legal information, and policies. -->
            <div class="space-y-4">
                <h3 class="font-bold text-white uppercase tracking-wider text-xs">About</h3>
                <ul class="space-y-3 font-medium text-slate-400">
                    <li><a href="#" class="hover:text-white transition-colors">Fee</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Listing Application</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Privacy policy</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Disclaimer</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">User conduct code</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Terms of service</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Margin Facility Agreement</a></li>
                </ul>
            </div>
            
            <!-- Column 2: Services -->
            <!-- Links for developer-focused services and other offerings. -->
            <div class="space-y-4">
                <h3 class="font-bold text-white uppercase tracking-wider text-xs">Services</h3>
                <ul class="space-y-3 font-medium text-slate-400">
                    <li><a href="#" class="hover:text-white transition-colors">Bug Bounty</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                </ul>
            </div>

            <!-- Column 3: Tutorials -->
            <!-- A collection of educational resources for users. -->
            <div class="space-y-4">
                <h3 class="font-bold text-white uppercase tracking-wider text-xs">Tutorials</h3>
                <ul class="space-y-3 font-medium text-slate-400">
                    <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Grid Trading Bot</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Video</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                </ul>
            </div>

            <!-- Column 4: Contact -->
            <!-- Channels for users to get in touch or find official information. -->
            <div class="space-y-4">
                <h3 class="font-bold text-white uppercase tracking-wider text-xs">Contact</h3>
                <ul class="space-y-3 font-medium text-slate-400">
                    <li><a href="mailto:support@tradingsafe.com" class="hover:text-white transition-colors">Email</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Live chat</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Announcements</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Official Verification</a></li>
                </ul>
            </div>
            
            <!-- Column 5 & 6: Copyright and Socials -->
            <!-- This block spans two columns on larger screens for better visual balance. -->
            <div class="col-span-2 space-y-4">
                 <h3 class="font-bold text-white uppercase tracking-wider text-xs">TradingSafe</h3>
                 <p class="text-slate-500">Platform bot trading otomatis dengan performa tinggi dan keamanan terjamin.</p>
                 <!-- Social media icons can be added here later -->
            </div>
        </div>

        <!-- Bottom Bar: Copyright -->
        <!-- A separate bar at the very bottom for the copyright notice. -->
        <div class="mt-16 pt-8 border-t border-slate-800 text-center text-slate-500">
            <p>&copy; <?php echo date("Y"); ?> TradingSafe. All rights reserved.</p>
        </div>

    </div>
</footer>




</body>
</html>