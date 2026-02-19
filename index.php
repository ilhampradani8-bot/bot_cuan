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

<nav class="fixed w-full z-[100] glass-nav border-b border-slate-100" x-data="{ openLayanan: false }">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        
        <div class="text-2xl font-extrabold text-blue-900 tracking-tight cursor-pointer" onclick="window.location.href='index.php'">
            Trading<span class="text-blue-600">Safe</span>
        </div>

        <div class="hidden lg:flex space-x-10 text-sm font-semibold text-slate-600">
            <button @click="openLayanan = !openLayanan" class="flex items-center gap-1 hover:text-blue-600 transition outline-none">
                Layanan 
                <svg class="w-4 h-4 transition-transform" :class="openLayanan ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <a href="#cara-kerja" class="hover:text-blue-600 transition">Cara Kerja</a>
            <a href="#faq" class="hover:text-blue-600 transition">FAQ</a>
            <a href="#harga" class="hover:text-blue-600 transition">Harga</a>
        </div>

        <div class="flex items-center space-x-4">
            <a href="web_dashboard/login.php" class="text-sm font-bold text-slate-700 hover:text-blue-600">Login</a>
            <a href="web_dashboard/register.php" class="bg-blue-600 text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition">
                Mulai Gratis
            </a>
        </div>
    </div>

    <div x-show="openLayanan" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         @click.away="openLayanan = false"
         class="absolute left-0 w-full bg-white border-b border-slate-200 shadow-2xl py-12">
        
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                
                <a href="#" class="group p-4 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-1">Trading Otomatis 24/7</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Eksekusi tanpa henti di server cloud VPS khusus kami.</p>
                </a>

                <a href="#" class="group p-4 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-lg flex items-center justify-center mb-4 group-hover:bg-green-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-1">Laporan Profit</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Analisis performa pertumbuhan aset mingguan & bulanan.</p>
                </a>

                <a href="#" class="group p-4 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-1">Kalkulator Trading</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Simulasi kalkulasi profit dan risiko sebelum eksekusi.</p>
                </a>

                <a href="#" class="group p-4 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-red-50 text-red-600 rounded-lg flex items-center justify-center mb-4 group-hover:bg-red-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-1">Manajemen Risiko</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Fitur stop-loss dan proteksi saldo otomatis.</p>
                </a>

                <a href="#" class="group p-4 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center mb-4 group-hover:bg-purple-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-1">Edukasi & Training</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Panduan strategi sniper dan tutorial penggunaan bot.</p>
                </a>

                <a href="#" class="group p-4 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center mb-4 group-hover:bg-indigo-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-1">Integrasi Cepat</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Hubungkan API Key Bursa Anda dalam hitungan menit.</p>
                </a>

                <a href="https://wa.me/6288971071138" class="group p-4 rounded-xl hover:bg-slate-50 transition">
                    <div class="w-10 h-10 bg-yellow-50 text-yellow-600 rounded-lg flex items-center justify-center mb-4 group-hover:bg-yellow-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-1">CS Support 24/7</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Bantuan teknis langsung dari developer melalui WhatsApp.</p>
                </a>

            </div>
        </div>
    </div>
</nav>

    <header class="pt-40 pb-20 hero-gradient px-6">
        <div class="max-w-5xl mx-auto text-center">
            <span class="bg-blue-100 text-blue-700 text-[10px] font-extrabold uppercase tracking-widest px-4 py-1.5 rounded-full mb-6 inline-block">
                🚀 Multi-Exchange Sniper Bot Engine
            </span>
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-8">
                Satu Bot untuk <br> <span class="text-blue-600">Semua Bursa Crypto.</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-500 mb-10 max-w-2xl mx-auto leading-relaxed">
                Optimalkan profit Anda dengan sniper bot berbasis Rust. Terintegrasi dengan Indodax dan segera hadir untuk bursa global lainnya.
            </p>
            
            <div id="integrasi" class="mt-10 flex flex-wrap justify-center items-center gap-8 opacity-40 grayscale hover:grayscale-0 transition-all duration-500">
                <span class="font-bold text-xl">INDODAX</span>
                <span class="font-bold text-xl">BINANCE</span>
                <span class="font-bold text-xl">BYBIT</span>
                <span class="font-bold text-xl">OKX</span>
                <span class="font-bold text-xl">KUCOIN</span>
                <span class="font-bold text-xl">TOKOCRYPTO</span>
            </div>
            
            <div class="mt-12 flex flex-col md:flex-row justify-center gap-4">
                <a href="web_dashboard/register.php" class="bg-slate-900 text-white px-10 py-4 rounded-xl font-bold text-lg hover:bg-slate-800 transition shadow-2xl">
                    Daftar & Hubungkan API
                </a>
            </div>
        </div>
    </header>

        <section id="fitur" class="py-24 bg-white border-t border-slate-50">
    <div class="max-w-4xl mx-auto px-6 text-center">
        
        <h2 class="text-3xl md:text-4xl font-extrabold mb-4 text-slate-900">Standar Keamanan & Infrastruktur</h2>
        <p class="text-slate-500 mb-16 max-w-2xl mx-auto">TradingSafe dibangun di atas infrastruktur militer untuk memastikan keamanan aset dan kecepatan eksekusi tanpa kompromi.</p>

        <div class="grid md:grid-cols-2 gap-y-12 gap-x-16 text-left">
            
            <div class="flex items-start gap-5">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-1">Engine Rust Performa Tinggi</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Menggunakan bahasa pemrograman Rust (teknologi inti Blockchain Solana & Polkadot) untuk menjamin eksekusi tanpa delay.</p>
                </div>
            </div>

            <div class="flex items-start gap-5">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-1">Enkripsi AES-256 & TLS 1.3</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Seluruh API Key dan data sensitif dienkripsi menggunakan standar militer AES-256 di sisi server.</p>
                </div>
            </div>

            <div class="flex items-start gap-5">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04kM12 21.48l.307-.13c4.757-2.013 8.193-6.143 8.193-10.99 0-1.44-.265-2.822-.751-4.09l-.13-.306M12 21.48l-.307-.13C6.936 19.337 3.5 15.207 3.5 10.36c0-1.44.265-2.822.751-4.09l.13-.306"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-1">Kepatuhan OJK, Bappebti & OSS</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Terdaftar resmi sebagai penyelenggara teknologi (OSS NIB) dan patuh terhadap regulasi perdagangan kripto di Indonesia.</p>
                </div>
            </div>

            <div class="flex items-start gap-5">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-1">Sertifikasi ISO 27001 & SOC2</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Audit keamanan informasi internasional ISO 27001 dan kepatuhan SOC2 Type II untuk integritas data pengguna.</p>
                </div>
            </div>

            <div class="flex items-start gap-5">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-1">Admin & CS Reader 24/7</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Tim bantuan teknis profesional yang siap membantu kendala operasional Anda kapan pun melalui jalur prioritas.</p>
                </div>
            </div>

            <div class="flex items-start gap-5">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-1">Infrastruktur Multi-Cloud</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Server redundan di Singapura & Jerman dengan SLA Uptime 99.99% untuk menjamin bot terus berjalan tanpa henti.</p>
                </div>
            </div>

        </div>
        </div>
</section>

    <section id="harga" class="py-24 bg-slate-900 text-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold mb-4">Mulai Trading Presisi Hari Ini</h2>
            <p class="text-slate-400">Pilih akses penuh atau konsultasikan strategi Anda bersama tim ahli kami.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            
            <div class="bg-white text-slate-900 rounded-3xl p-10 relative border-4 border-blue-600 shadow-2xl shadow-blue-500/20">
                <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-blue-600 text-white px-6 py-2 rounded-full text-[11px] font-black uppercase tracking-widest shadow-lg">
                    🔥 Early Access - Sisa 10 Slot
                </div>
                
                <h3 class="text-xl font-bold mb-2">Premium Sniper Access</h3>
                <p class="text-xs text-slate-400 mb-6">Akses penuh ke semua fitur mesin Rust.</p>
                
                <div class="mb-8">
                    <span class="text-sm text-slate-400 line-through">Rp 500.000</span>
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-black text-blue-700">Rp 50K</span>
                        <span class="text-slate-500 font-medium">/ bulan</span>
                    </div>
                </div>

                <ul class="text-left space-y-4 mb-10 text-sm text-slate-600">
                    <li class="flex items-center gap-3 font-medium">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        Unlimited API Key Integration
                    </li>
                    <li class="flex items-center gap-3 font-medium">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        Eksekusi Server-Side 24/7
                    </li>
                    <li class="flex items-center gap-3 font-medium">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        Support Semua Pair Indodax
                    </li>
                </ul>

                <a href="web_dashboard/register.php" class="block w-full bg-blue-600 text-white text-center py-4 rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                    Ambil Slot Promo Sekarang
                </a>
            </div>

            <div class="bg-slate-800 rounded-3xl p-10 border border-slate-700 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-2">Belum Yakin?</h3>
                    <p class="text-sm text-slate-400 mb-8 leading-relaxed">Lihat bagaimana algoritma kami bekerja secara real-time atau tanyakan langsung kendala teknis Anda.</p>
                    
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-xl">🧪</div>
                            <div>
                                <h4 class="text-sm font-bold">Simulator Profit</h4>
                                <p class="text-[10px] text-slate-500">Uji strategi tanpa risiko aset asli.</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-xl">👨‍💻</div>
                            <div>
                                <h4 class="text-sm font-bold">Direct Support</h4>
                                <p class="text-[10px] text-slate-500">Bantuan setup API Key via remote.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 space-y-3">
                    <a href="web_dashboard/register.php" class="block w-full bg-slate-100 text-slate-900 text-center py-4 rounded-2xl font-bold hover:bg-white transition">
                        Mulai Simulasikan
                    </a>
                    <a href="https://wa.me/6288971071138?text=Halo%20Admin%20TradingSafe,%20saya%20tertarik%20dengan%20promo%20Early%20Access" target="_blank" class="block w-full border border-slate-600 text-white text-center py-4 rounded-2xl font-bold hover:bg-slate-700 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Tanya di WA Admin
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


  <footer class="bg-slate-50 pt-20 pb-10 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-12 mb-16">
            
            <div class="col-span-2">
                <div class="text-2xl font-extrabold text-blue-900 tracking-tight mb-6">
                    Trading<span class="text-blue-600">Safe</span>
                </div>
                <p class="text-sm text-slate-500 leading-relaxed mb-6 max-w-sm">
                    Infrastruktur trading otomatis berperforma tinggi yang didukung oleh teknologi Rust. Memberikan presisi eksekusi tingkat milidetik untuk pasar aset digital global.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="text-slate-400 hover:text-blue-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-blue-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h5 class="text-xs font-bold uppercase tracking-widest text-slate-900 mb-6">Produk</h5>
                <ul class="text-sm text-slate-500 space-y-4">
                    <li><a href="#" class="hover:text-blue-600 transition">Sniper Bot Engine</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Auto-Rebalance</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">API Documentation</a></li>
                </ul>
            </div>

            <div>
                <h5 class="text-xs font-bold uppercase tracking-widest text-slate-900 mb-6">Sumber Daya</h5>
                <ul class="text-sm text-slate-500 space-y-4">
                    <li><a href="#fitur" class="hover:text-blue-600 transition">Keamanan Infrastruktur</a></li>
                    <li><a href="#harga" class="hover:text-blue-600 transition">Harga & Lisensi</a></li>
                    <li><a href="https://wa.me/6288971071138" class="hover:text-blue-600 transition">Pusat Bantuan</a></li>
                </ul>
            </div>

            <div>
                <h5 class="text-xs font-bold uppercase tracking-widest text-slate-900 mb-6">Legalitas</h5>
                <ul class="text-sm text-slate-500 space-y-4">
                    <li><a href="#" class="hover:text-blue-600 transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Kepatuhan Regulasi</a></li>
                </ul>
            </div>

        </div>

        <div class="border-t border-slate-200 pt-8 pb-8 flex flex-wrap gap-8 justify-center items-center opacity-60 grayscale">
            <span class="text-[10px] font-bold tracking-tighter border border-slate-300 px-2 py-1 rounded">ISO 27001 CERTIFIED</span>
            <span class="text-[10px] font-bold tracking-tighter border border-slate-300 px-2 py-1 rounded">SOC2 COMPLIANT</span>
            <span class="text-[10px] font-bold tracking-tighter border border-slate-300 px-2 py-1 rounded">SECURED BY AES-256</span>
            <span class="text-[10px] font-bold tracking-tighter border border-slate-300 px-2 py-1 rounded">BAPPEBTI COMPLIANT</span>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-slate-200 gap-4">
            <p class="text-[11px] text-slate-400 uppercase tracking-widest">
                &copy; 2026 TradingSafe International. All rights reserved.
            </p>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">All Systems Operational</span>
            </div>
        </div>
    </div>
</footer>




</body>
</html>