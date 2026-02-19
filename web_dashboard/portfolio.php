<?php
session_start();
require_once 'components/database.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - TradingSafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen">

    <nav class="bg-white px-6 py-4 border-b border-slate-200 flex justify-between items-center">
        <div class="font-bold text-slate-800">Risk & Portfolio Manager</div>
        <a href="easy.php" class="text-xs font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-lg hover:bg-blue-100">Kembali ke Bot</a>
    </nav>

    <div class="max-w-5xl mx-auto px-4 mt-8 space-y-6">
        
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-slate-900 text-white p-6 rounded-2xl shadow-lg">
                <p class="text-slate-400 text-xs font-bold uppercase mb-1">Estimasi Total Aset</p>
                <h2 class="text-3xl font-bold">Rp 0</h2>
                <p class="text-[10px] text-slate-500 mt-2">Updated: Just now</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-slate-400 text-xs font-bold uppercase mb-1">Profit Bulan Ini</p>
                <h2 class="text-3xl font-bold text-green-600">+ Rp 0</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-slate-400 text-xs font-bold uppercase mb-1">Win Rate (Est)</p>
                <h2 class="text-3xl font-bold text-blue-600">0%</h2>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200">
            <h3 class="font-bold text-slate-800 mb-4">🛡️ Aturan Manajemen Resiko</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                    <span class="text-sm text-slate-600">Maksimal Resiko Per Trade</span>
                    <span class="font-mono text-sm font-bold">2% (Rp 0)</span>
                </div>
                <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                    <span class="text-sm text-slate-600">Alokasi Saldo per Bot</span>
                    <span class="font-mono text-sm font-bold">100%</span>
                </div>
            </div>
        </div>

    </div>

</body>
</html>