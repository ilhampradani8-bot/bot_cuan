<?php
session_start();
require_once 'components/database.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upgrade Premium - TradingSafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen p-6 font-sans">

    <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100" x-data="{ method: 'bank' }">
        
        <div class="bg-slate-900 p-8 text-white text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <span class="bg-blue-600 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest mb-4 inline-block">Early Access Promo</span>
            <h1 class="text-3xl font-extrabold mb-2">Upgrade Premium</h1>
            <p class="text-slate-400 text-sm">Pilih metode pembayaran yang Anda inginkan.</p>
        </div>

        <div class="p-8">
            
            <div class="flex p-1 bg-slate-100 rounded-xl mb-8">
                <button @click="method = 'bank'" :class="method === 'bank' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-3 text-sm font-bold rounded-lg transition duration-200 flex items-center justify-center gap-2">
                    <span>🏦</span> Bank Transfer (IDR)
                </button>
                <button @click="method = 'crypto'" :class="method === 'crypto' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-3 text-sm font-bold rounded-lg transition duration-200 flex items-center justify-center gap-2">
                    <img src="https://cryptologos.cc/logos/tether-usdt-logo.png" class="w-4 h-4">
                    USDT (Global)
                </button>
            </div>

            <div x-show="method === 'bank'" x-transition:enter="transition ease-out duration-300">
                <div class="space-y-4 mb-8">
                    
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex justify-between items-center group hover:border-blue-300 transition cursor-pointer" onclick="navigator.clipboard.writeText('901593870244'); alert('No Rekening Seabank Disalin!')">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-orange-100 text-orange-600 text-[10px] font-bold px-2 py-0.5 rounded">SEABANK</span>
                            </div>
                            <div class="text-lg font-mono font-bold text-slate-800 tracking-wider">9015 9387 0244</div>
                            <div class="text-xs text-slate-500 font-bold">A.N. ILHAM PRADANI</div>
                        </div>
                        <button class="text-xs bg-white border border-slate-200 px-3 py-1 rounded text-slate-500 font-bold group-hover:text-blue-600 group-hover:border-blue-200">SALIN</button>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex justify-between items-center group hover:border-blue-300 transition cursor-pointer" onclick="navigator.clipboard.writeText('1210013633023'); alert('No Rekening Mandiri Disalin!')">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded">MANDIRI</span>
                            </div>
                            <div class="text-lg font-mono font-bold text-slate-800 tracking-wider">1210 0136 33023</div>
                            <div class="text-xs text-slate-500 font-bold">A.N. ILHAM PRADANI</div>
                        </div>
                        <button class="text-xs bg-white border border-slate-200 px-3 py-1 rounded text-slate-500 font-bold group-hover:text-blue-600 group-hover:border-blue-200">SALIN</button>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex justify-between items-center group hover:border-blue-300 transition cursor-pointer" onclick="navigator.clipboard.writeText('100122377787'); alert('No Rekening Jago Disalin!')">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded">BANK JAGO</span>
                            </div>
                            <div class="text-lg font-mono font-bold text-slate-800 tracking-wider">1001 2237 7787</div>
                            <div class="text-xs text-slate-500 font-bold">A.N. ILHAM PRADANI</div>
                        </div>
                        <button class="text-xs bg-white border border-slate-200 px-3 py-1 rounded text-slate-500 font-bold group-hover:text-blue-600 group-hover:border-blue-200">SALIN</button>
                    </div>

                    <div class="text-center pt-4 border-t border-slate-100">
                        <p class="text-xs text-slate-400 mb-1">Total Transfer</p>
                        <p class="text-4xl font-black text-blue-600">Rp 50.000</p>
                        <p class="text-[10px] text-red-500 mt-2 italic">*Mohon transfer sesuai nominal pas.</p>
                    </div>
                </div>
            </div>

            <div x-show="method === 'crypto'" x-transition:enter="transition ease-out duration-300" style="display: none;">
                <div class="bg-slate-900 text-white p-6 rounded-2xl mb-8 relative overflow-hidden shadow-inner">
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="font-bold text-xl text-white">USDT (ERC20)</h3>
                                <p class="text-xs text-slate-400 mt-1">Network: Ethereum (ETH/ERC20)</p>
                            </div>
                            <img src="https://cryptologos.cc/logos/tether-usdt-logo.png" class="w-10 h-10 filter brightness-0 invert">
                        </div>
                        
                        <div class="bg-black/30 p-4 rounded-xl border border-slate-700 mb-6">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Wallet Address</label>
                            <div class="flex items-center justify-between gap-2">
                                <code class="text-xs font-mono text-yellow-400 break-all leading-relaxed">0x3b36AfaFC61906F496263666d1142A58C466df42</code>
                                <button onclick="navigator.clipboard.writeText('0x3b36AfaFC61906F496263666d1142A58C466df42'); alert('Alamat Wallet Disalin!')" class="text-xs bg-slate-700 hover:bg-slate-600 px-3 py-2 rounded text-white font-bold transition flex-shrink-0">
                                    COPY
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-between items-end border-t border-slate-700 pt-4">
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase font-bold">Total Payment</p>
                                <p class="text-3xl font-bold text-green-400">$ 3.50 <span class="text-sm text-slate-400 font-normal">USDT</span></p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-slate-500">~ Rp 50.000</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-red-50 border border-red-100 p-3 rounded-lg flex gap-3 items-start mb-8">
                    <span class="text-lg">⚠️</span>
                    <p class="text-xs text-red-600 leading-relaxed">
                        <b>PENTING:</b> Pastikan Anda mengirim ke jaringan <b>ERC20 (Ethereum)</b>. Mengirim ke jaringan lain (seperti BEP20/TRC20) dapat menyebabkan aset hilang permanen.
                    </p>
                </div>
            </div>

            <hr class="border-slate-100 mb-8">

            <form action="process_payment.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="payment_method" :value="method">
                
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Konfirmasi Pembayaran
                </h3>
                
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Upload Bukti Transfer / Screenshot</label>
                    <div class="relative">
                        <input type="file" name="proof" class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-3 file:px-4
                            file:rounded-xl file:border-0
                            file:text-xs file:font-bold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100 transition
                            border border-slate-200 rounded-xl cursor-pointer
                        " required>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2 ml-1">Format: JPG/PNG. Maks 2MB.</p>
                </div>

                <div class="flex gap-4">
                    <a href="easy.php" class="w-1/3 border border-slate-200 text-slate-500 py-3.5 rounded-xl font-bold text-sm hover:bg-slate-50 transition text-center flex items-center justify-center">Batal</a>
                    <button type="submit" class="w-2/3 bg-blue-600 text-white py-3.5 rounded-xl font-bold text-sm hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Kirim Bukti Pembayaran
                    </button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>