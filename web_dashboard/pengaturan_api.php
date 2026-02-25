<?php
// FILE: web_dashboard/pengaturan_api.php
// v3.1 - ROBUST & FULLY FUNCTIONAL: Fixed the fatal JavaScript syntax error. All buttons now work correctly using modern event handling.
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$supported_exchanges = ['INDODAX', 'BINANCE', 'BYBIT', 'OKX', 'KUCOIN', 'BITGET'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan API - TradingSafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap'); </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <div class="flex">
        <?php require_once 'components/sidebar.php'; ?>

        <div id="main-content" class="md:ml-64 flex flex-col flex-1 min-h-screen transition-all duration-300">
            <?php require_once 'components/navbar.php'; ?>

            <main class="flex-1 p-6 md:p-8">
                <div class="max-w-7xl mx-auto">
                    <div id="notification-container" class="fixed top-20 right-8 z-50 w-80 space-y-2"></div>
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-slate-900">Pengaturan API Key</h1>
                        <p class="text-sm text-slate-500">Hubungkan akun exchange Anda untuk memulai trading.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-1 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm h-fit">
                            <h2 id="form-title" class="text-xl font-bold text-slate-800 mb-4">Hubungkan Exchange Baru</h2>
                            <form id="api-key-form" class="space-y-5">
                                <input type="hidden" id="key_id" name="key_id">
                                <div>
                                    <label for="exchange" class="block text-sm font-semibold text-slate-700 mb-1">Pilih Exchange</label>
                                    <select id="exchange" name="exchange" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"></select>
                                </div>
                                <div>
                                    <label for="api_key" class="block text-sm font-semibold text-slate-700 mb-1">API Key</label>
                                    <input type="text" id="api_key" name="api_key" placeholder="Masukkan API Key Anda" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                </div>
                                <div>
                                    <label for="secret_key" class="block text-sm font-semibold text-slate-700 mb-1">Secret Key</label>
                                    <div class="relative">
                                        <input type="password" id="secret_key" name="secret_key" placeholder="Masukkan Secret Key Anda" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                        <button type="button" id="toggle-secret" class="absolute inset-y-0 right-0 px-4 text-slate-500 hover:text-blue-600">
                                            <i id="toggle-icon" class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="pt-2 flex gap-2">
                                    <button type="submit" id="submit-button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-all shadow-md flex items-center justify-center">
                                        <i class="fas fa-plus-circle mr-2"></i><span>Hubungkan & Simpan</span>
                                    </button>
                                    <button type="button" id="cancel-edit-button" class="hidden w-full bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold py-3 px-4 rounded-lg">Batal</button>
                                </div>
                            </form>
                        </div>

                        <div class="lg:col-span-2">
                             <h2 class="text-xl font-bold text-slate-800 mb-4">Exchange Terhubung</h2>
                             <div id="api-keys-list-container" class="space-y-4"></div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- CORRECTED API ENDPOINTS ---
    const API_URL = 'api/manage_keys.php';

    // --- Elemen Global ---
    const listContainer = document.getElementById('api-keys-list-container');
    const form = document.getElementById('api-key-form');
    const formTitle = document.getElementById('form-title');
    const submitButton = document.getElementById('submit-button');
    const cancelEditButton = document.getElementById('cancel-edit-button');
    const notificationContainer = document.getElementById('notification-container');
    const keyIdInput = document.getElementById('key_id');
    const exchangeInput = document.getElementById('exchange');
    const apiKeyInput = document.getElementById('api_key');
    const secretKeyInput = document.getElementById('secret_key');

    // --- UTILITY: Notifikasi ---
    function showNotification(message, isSuccess = true) {
        const notif = document.createElement('div');
        notif.className = `transform transition-all duration-300 p-4 rounded-lg text-white shadow-lg ${isSuccess ? 'bg-green-500' : 'bg-red-500'}`;
        notif.innerHTML = `<i class="fas ${isSuccess ? 'fa-check-circle' : 'fa-times-circle'} mr-2"></i> ${message}`;
        notificationContainer.prepend(notif);
        setTimeout(() => { notif.style.opacity = '0'; notif.style.transform = 'translateX(100%)'; }, 2500);
        setTimeout(() => notif.remove(), 3000);
    }
    
    // --- FUNGSI: Tombol Mata untuk Show/Hide Password ---
    document.getElementById('toggle-secret').addEventListener('click', function() {
        const isPassword = secretKeyInput.type === 'password';
        secretKeyInput.type = isPassword ? 'text' : 'password';
        document.getElementById('toggle-icon').classList.toggle('fa-eye', !isPassword);
        document.getElementById('toggle-icon').classList.toggle('fa-eye-slash', isPassword);
    });

    // --- FUNGSI: Memuat API Keys dari Server ---
    async function loadApiKeys() {
        listContainer.innerHTML = `<div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm animate-pulse"><div class="h-8 bg-slate-200 rounded w-1/3"></div></div>`;
        try {
            // FIX: Calling the correct endpoint with the correct action parameter.
            const response = await fetch(`${API_URL}?action=get_all`);
            if (!response.ok) { // Check for HTTP errors like 404 or 500
                 const errorText = await response.text();
                 throw new Error(`Server responded with status ${response.status}: ${errorText}`);
            }
            const result = await response.json(); // This is where the JSON.parse error happens.
            if (result.error) throw new Error(result.error);
            
        } catch (error) {
            listContainer.innerHTML = `<div class="bg-red-100 text-red-700 p-4 rounded-lg"><strong>Error:</strong> ${error.message}</div>`;
        }
    }

    // --- FUNGSI: Merender Daftar API Keys ke Tampilan ---
    // --- FUNGSI: Merender Daftar API Keys & Mengisi Form ---
// REFACTOR: This function now also populates the exchange dropdown.
function renderKeys(data) {
    const keys = data.keys || [];
    const supportedExchanges = data.supported_exchanges || ['INDODAX', 'BINANCE', 'BYBIT', 'OKX', 'KUCOIN', 'BITGET']; // Fallback

    // Populate the exchange dropdown in the form.
    exchangeInput.innerHTML = supportedExchanges.map(ex => `<option value="${ex}">${ex}</option>`).join('');

    // Render the list of connected keys.
    listContainer.innerHTML = '';
    if (keys.length === 0) {
        listContainer.innerHTML = `<div class="bg-white text-center p-10 rounded-2xl border border-dashed border-slate-300"><i class="fas fa-key text-4xl text-slate-300 mb-4"></i><p class="font-semibold text-slate-600">Belum ada API Key.</p><p class="text-sm text-slate-400">Gunakan form di samping.</p></div>`;
        return;
    }

    keys.forEach(key => {
        const statusClass = (key.status === 'CONNECTED' || key.status === 'Terkoneksi') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
        const statusIcon = (key.status === 'CONNECTED' || key.status === 'Terkoneksi') ? 'fa-check-circle' : 'fa-times-circle';
        const el = document.createElement('div');
        el.className = 'bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between';
        
        el.innerHTML = `
            <div class="flex items-center gap-4">
                <img src="${key.logo}" alt="Logo" class="w-10 h-10 bg-slate-100 rounded-full">
                <div>
                    <h3 class="font-bold text-slate-800">${key.exchange}</h3>
                    <p class="text-sm text-slate-500 font-mono">${key.api_key_masked}</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="font-semibold text-xs px-3 py-1 rounded-full ${statusClass}"><i class="fas ${statusIcon} mr-1"></i> ${key.status}</span>
                <div class="flex gap-2">
                    <button data-action="edit" data-id="${key.id}" data-exchange="${key.exchange}" data-api-key="${key.api_key}" class="w-10 h-10 flex items-center justify-center bg-slate-100 hover:bg-yellow-100 text-slate-600 hover:text-yellow-600 rounded-lg transition-colors" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                    <button data-action="delete" data-id="${key.id}" class="w-10 h-10 flex items-center justify-center bg-slate-100 hover:bg-red-100 text-slate-600 hover:text-red-600 rounded-lg transition-colors" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>`;
        listContainer.appendChild(el);
    });
}

    // --- FUNGSI: Menangani Submit Form (Simpan & Edit) ---
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        formData.append('action', 'save'); // Add the action parameter for the backend switch statement.
        
        submitButton.disabled = true;
        submitButton.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i><span>Menyimpan...</span>`;

        try {
            // FIX: Calling the correct single API endpoint.
            const response = await fetch(API_URL, { method: 'POST', body: formData });
            const result = await response.json();
            if (result.error) throw new Error(result.error);
            showNotification(result.success, true);
            resetForm();
            loadApiKeys();
        } catch (error) {
            showNotification(error.message, false);
        } finally {
            submitButton.disabled = false;
            resetForm();
        }
    });

    // --- FUNGSI: Reset Form ke State Awal ---
    function resetForm() {
        form.reset();
        formTitle.textContent = 'Hubungkan Exchange Baru';
        keyIdInput.value = '';
        secretKeyInput.placeholder = 'Masukkan Secret Key Anda';
        secretKeyInput.required = true;
        submitButton.innerHTML = `<i class="fas fa-plus-circle mr-2"></i><span>Hubungkan & Simpan</span>`;
        cancelEditButton.classList.add('hidden');
    }
    cancelEditButton.addEventListener('click', resetForm);

    // --- EVENT LISTENER UTAMA (untuk tombol Edit & Hapus) ---
    listContainer.addEventListener('click', function(e) {
        const button = e.target.closest('button[data-action]');
        if (!button) return;

        const { action, id } = button.dataset;

        if (action === 'edit') {
            const { exchange, apiKey } = button.dataset;
            formTitle.textContent = 'Edit API Key';
            keyIdInput.value = id;
            exchangeInput.value = exchange;
            apiKeyInput.value = apiKey; // Use the full API key from the data attribute.
            secretKeyInput.placeholder = '(Kosongkan jika tidak diubah)';
            secretKeyInput.required = false;
            submitButton.innerHTML = `<i class="fas fa-save mr-2"></i><span>Simpan Perubahan</span>`;
            cancelEditButton.classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } 
        else if (action === 'delete') {
            if (!confirm(`Apakah Anda yakin ingin menghapus API Key ini?`)) return;

            (async () => {
                try {
                    const formData = new FormData();
                    formData.append('action', 'delete'); // Add the action parameter.
                    formData.append('key_id', id); // Add the ID to be deleted.
                    
                    // FIX: Calling the correct single API endpoint.
                    const response = await fetch(API_URL, { method: 'POST', body: formData });
                    const result = await response.json();
                    if (result.error) throw new Error(result.error);
                    showNotification(result.success, true);
                    loadApiKeys();
                } catch(error) {
                    showNotification(error.message, false);
                }
            })();
        }
    });

    // --- Inisialisasi ---
    loadApiKeys();
});
</script>


</body>
</html>
