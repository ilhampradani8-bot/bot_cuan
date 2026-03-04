<?php
// FILE: web_dashboard/admin/footer.php
// Footer umum untuk semua halaman admin, berisi semua logika JavaScript.
?>
    </main> <!-- Penutup dari <main> yang dibuka di header.php -->

    <!-- Modal untuk Tambah/Edit FAQ (dibutuhkan di halaman FAQ) -->
    <div id="faq-modal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 id="faq-modal-title" class="text-xl font-bold text-slate-800">Tambah Pertanyaan Baru</h3>
            </div>
            <form id="faq-form" class="p-6 space-y-4">
                <input type="hidden" id="faq-id">
                <input type="hidden" id="faq-action" value="add">
                <div>
                    <label for="faq-question" class="block text-xs font-bold uppercase text-slate-400 mb-1">Pertanyaan</label>
                    <input type="text" id="faq-question" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 outline-none" required>
                </div>
                <div>
                    <label for="faq-answer" class="block text-xs font-bold uppercase text-slate-400 mb-1">Jawaban</label>
                    <textarea id="faq-answer" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 outline-none" required></textarea>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" id="close-faq-modal-btn" class="flex-1 px-4 py-3 text-slate-500 font-bold hover:bg-slate-50 rounded-xl transition-all">Batal</button>
                    <button type="submit" id="faq-submit-btn" class="flex-1 px-4 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">Simpan FAQ</button>
                </div>
            </form>
        </div>
    </div>

        <!-- Modal untuk Set Expiry Date (BARU) -->
    <div id="expiry-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50">
      <div class="relative mx-auto p-8 border w-96 shadow-lg rounded-xl bg-white">
        <div class="text-center">
          <h3 class="text-2xl font-bold text-slate-800">Set Expiry Date</h3>
          <div class="mt-4">
            <p class="text-slate-600 mb-4">Pilih tanggal kedaluwarsa baru untuk user <strong id="expiry-user-id-display" class="text-blue-600"></strong>:</p>
            <input type="text" id="expiry-date-picker" class="border p-2 rounded w-full cursor-pointer" placeholder="Pilih tanggal...">
          </div>
          <div class="flex justify-end mt-8">
            <button id="expiry-cancel-btn" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg mr-3">Batal</button>
            <button id="expiry-save-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Simpan</button>
          </div>
        </div>
      </div>
    </div>


        <!-- ======================================================= -->
    <!-- Modal BARU untuk Melihat Log Aktivitas Pengguna         -->
    <!-- ======================================================= -->
    <div id="logs-modal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-start justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl my-8">
            <!-- Modal Header -->
            <div class="p-6 border-b border-slate-100 sticky top-0 bg-white rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Riwayat Aktivitas Pengguna</h3>
                        <p id="logs-user-info" class="text-sm text-slate-500">Memuat info pengguna...</p>
                    </div>
                    <button id="close-logs-modal-btn" class="p-2 rounded-full hover:bg-slate-100">
                        <i class="fa-solid fa-xmark text-slate-600"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div id="logs-content" class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <!-- Konten log akan dimuat di sini oleh JavaScript -->
                <p class="text-center text-slate-400 animate-pulse">Memuat riwayat log...</p>
            </div>
        </div>
    </div>



<!-- Library Flatpickr (Kalender) -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
// =================================================================
// BLOK UTAMA JAVASCRIPT UNTUK ADMIN DASHBOARD
// =================================================================
document.addEventListener('DOMContentLoaded', () => {

    // ------------------------------------------------------------
    // Bagian 1: Inisialisasi & Fungsi Global
    // ------------------------------------------------------------
    
    // Fungsi untuk membersihkan input HTML dan mencegah XSS
    function escapeHTML(s) { 
        if (typeof s !== 'string') return '';
        const p = document.createElement('p'); 
        p.textContent = s; 
        return p.innerHTML; 
    }
    
    // Dapatkan halaman saat ini dari URL untuk menjalankan JS yang relevan
    const currentPage = new URLSearchParams(window.location.search).get('page') || 'users';

    // -------------------------------------------------------------
    // Bagian 2: Router untuk Menjalankan Fungsi Sesuai Halaman
    // -------------------------------------------------------------
    
    // Jalankan jika di halaman 'overview'
    if (currentPage === 'overview') {
        const dashboardContent = document.getElementById('dashboard-content');
        if (dashboardContent) {
            loadDashboardData();
            // Muat ulang data setiap 5 detik
            setInterval(loadDashboardData, 5000); 
        }
    }

    // ===>>> BAGIAN BARU UNTUK STRATEGY <<<===
    if (currentPage === 'strategy') {
        const pnlContainer = document.getElementById('global-pnl-container');
        if(pnlContainer) {
            loadStrategyData();
            // Muat ulang data PnL setiap 10 detik
            setInterval(() => loadStrategyData(true), 10000);

            // Tambahkan event listener untuk tombol Simpan
            document.getElementById('save-settings-btn').onclick = handleSaveSettings;
        }
    }
    
    // Jalankan jika di halaman 'faq'
    if (currentPage === 'faq') {
        const faqContainer = document.getElementById('faq-list-container');
        if (faqContainer) {
            loadAdminFAQs();
            
            // Event listeners untuk modal FAQ
            document.getElementById('add-faq-modal-btn').onclick = () => showFaqModal();
            document.getElementById('close-faq-modal-btn').onclick = () => hideFaqModal();
            document.getElementById('faq-form').onsubmit = handleFaqSubmit;
        }
    }
    
    // Jalankan jika di halaman 'chat'
    if (currentPage === 'chat') {
        const chatContainer = document.getElementById('live-chat-view');
        if(chatContainer){
            loadConversations();
            // Muat ulang daftar percakapan setiap 7 detik
            setInterval(loadConversations, 7000); 
            document.getElementById('reply-form').onsubmit = handleChatReply;
        }
    }


    // ------------------------------------------------------------
    // Bagian 3: Definisi Fungsi-Fungsi
    // ------------------------------------------------------------

    // --- FUNGSI UNTUK HALAMAN OVERVIEW ---\
    async function loadDashboardData() {
        try {
            const res = await fetch('../api/admin_get_stats.php');
            if (!res.ok) throw new Error(`Server error: ${res.status}`);
            const data = await res.json();
            
            const totalUsers = document.getElementById('total-users-stat');
            const activeBots = document.getElementById('active-bots-stat');
            const tradingVolume = document.getElementById('trading-volume-stat');
            const healthContainer = document.getElementById('system-health-stat');

            if (totalUsers) totalUsers.textContent = data.total_users;
            if (activeBots) activeBots.textContent = data.active_bots;
            if (tradingVolume) tradingVolume.textContent = data.total_volume_formatted;
            
            if (healthContainer) {
                healthContainer.classList.remove('animate-pulse');
                healthContainer.innerHTML = `
                    <div class="flex items-center justify-between text-xs"><span class="font-semibold text-slate-600">Rust Engine:</span><span class="font-bold ${data.engine_status.class}">${data.engine_status.text}</span></div>
                    <div class="flex items-center justify-between text-xs"><span class="font-semibold text-slate-600">CPU Usage:</span><span class="font-bold text-slate-800">${data.cpu_usage}%</span></div>
                    <div class="flex items-center justify-between text-xs"><span class="font-semibold text-slate-600">RAM Usage:</span><span class="font-bold text-slate-800">${data.ram_usage} MB</span></div>`;
            }
        } catch (e) {
            const dashboardContent = document.getElementById('dashboard-content');
            if(dashboardContent) dashboardContent.innerHTML = `<p class="text-red-500 col-span-4">Error memuat dashboard: ${e.message}</p>`;
        }
    }

    // ===>>> FUNGSI BARU UNTUK STRATEGY <<<===
    async function loadStrategyData(isPolling = false) {
        try {
            const res = await fetch('../api/admin_get_strategy_data.php');
            const data = await res.json();
            if (!data.success) throw new Error(data.error);

            // Update Global PnL
            const pnlStat = document.getElementById('global-pnl-stat');
            if (pnlStat) {
                pnlStat.textContent = data.global_pnl_formatted;
                pnlStat.parentElement.classList.remove('animate-pulse');
                pnlStat.classList.remove('text-green-600', 'text-red-600');
                pnlStat.classList.add(data.global_pnl >= 0 ? 'text-green-600' : 'text-red-600');
            }

            // Update pengaturan hanya jika bukan polling (untuk menghindari reset input pengguna)
            if (!isPolling) {
                const feeInput = document.getElementById('admin-fee-input');
                const maintenanceToggle = document.getElementById('maintenance-mode-toggle');
                const maintenanceText = document.getElementById('maintenance-status-text');

                if (feeInput) feeInput.value = data.admin_fee_percentage;
                if (maintenanceToggle) maintenanceToggle.checked = data.maintenance_mode_status;
                if (maintenanceText) maintenanceText.textContent = data.maintenance_mode_status ? 'Aktif' : 'Nonaktif';
            }
        } catch (e) {
            console.error('Gagal memuat data strategi:', e.message);
            const pnlStat = document.getElementById('global-pnl-stat');
            if(pnlStat) pnlStat.textContent = "Error";
        }
    }
    
    async function handleSaveSettings(e) {
        const saveBtn = e.target;
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Menyimpan...';

        const adminFee = document.getElementById('admin-fee-input').value;
        const maintenanceStatus = document.getElementById('maintenance-mode-toggle').checked;

        try {
            const res = await fetch('../api/admin_update_strategy_settings.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    admin_fee: parseFloat(adminFee),
                    maintenance_status: maintenanceStatus
                })
            });
            const result = await res.json();

            if (result.success) {
                alert('Sukses! Pengaturan telah disimpan.');
                // Update teks status maintenance mode
                document.getElementById('maintenance-status-text').textContent = maintenanceStatus ? 'Aktif' : 'Nonaktif';
            } else {
                throw new Error(result.error || 'Terjadi kesalahan yang tidak diketahui.');
            }
        } catch (err) {
            alert(`Gagal menyimpan pengaturan: ${err.message}`);
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fa-solid fa-save mr-2"></i>Simpan Perubahan';
        }
    }


    // --- FUNGSI UNTUK HALAMAN FAQ ---\
    const faqModal = document.getElementById('faq-modal');
    // Fungsi untuk menampilkan modal (baik untuk 'tambah' atau 'edit')
    window.showFaqModal = (id = null, question = '', answer = '') => {
        const form = document.getElementById('faq-form');
        form.reset();
        document.getElementById('faq-id').value = id || '';
        document.getElementById('faq-question').value = question;
        document.getElementById('faq-answer').value = answer;
        document.getElementById('faq-action').value = id ? 'update' : 'add';
        document.getElementById('faq-modal-title').textContent = id ? 'Edit Pertanyaan' : 'Tambah Pertanyaan Baru';
        document.getElementById('faq-submit-btn').textContent = id ? 'Simpan Perubahan' : 'Simpan FAQ';
        if (faqModal) faqModal.classList.remove('hidden');
    }
    function hideFaqModal() { if (faqModal) faqModal.classList.add('hidden'); }
    async function handleFaqSubmit(e) {
        e.preventDefault();
        const id = document.getElementById('faq-id').value;
        const action = document.getElementById('faq-action').value;
        const question = document.getElementById('faq-question').value;
        const answer = document.getElementById('faq-answer').value;
        const api = action === 'update' ? '../api/admin_update_faq.php' : '../api/admin_add_faq.php';
        try {
            const res = await fetch(api, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id, question, answer }) });
            const data = await res.json();
            if (data.success) { hideFaqModal(); loadAdminFAQs(); } else { throw new Error(data.error); }
        } catch (e) { alert(`Gagal: ${e.message}`); }
    }
    window.deleteFaq = async (id) => {
        if (!confirm('Yakin ingin menghapus FAQ ini?')) return;
        try {
            const res = await fetch('../api/admin_delete_faq.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id }) });
            const data = await res.json();
            if (data.success) { loadAdminFAQs(); } else { throw new Error(data.error); }
        } catch (e) { alert(`Gagal: ${e.message}`); }
    }
    async function loadAdminFAQs() {
        const c = document.getElementById('faq-list-container');
        if (!c) return;
        c.innerHTML = '<p class="text-slate-400 animate-pulse">Memuat FAQ...</p>';
        try {
            const res = await fetch('../api/admin_get_faqs.php');
            const data = await res.json();
            c.innerHTML = '';
            if (!data.faqs || data.faqs.length === 0) { c.innerHTML = '<p class="text-slate-500">Belum ada FAQ.</p>'; return; }
            data.faqs.forEach(f => {
                const d = document.createElement('div');
                d.className = 'p-5 bg-white border border-slate-200 rounded-xl shadow-sm';
                d.innerHTML = `
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-bold text-slate-800">${escapeHTML(f.question)}</h4>
                            <p class="text-sm text-slate-600 mt-1">${escapeHTML(f.answer)}</p>
                        </div>
                        <div class="flex-shrink-0 ml-4">
                            <button onclick="showFaqModal(${f.id}, '${escapeHTML(f.question).replace(/'/g, "&apos;")}', '${escapeHTML(f.answer).replace(/'/g, "&apos;")}')" class="p-2 text-slate-500 hover:text-blue-600"><i class="fa-solid fa-pencil"></i></button>
                            <button onclick="deleteFaq(${f.id})" class="p-2 text-slate-500 hover:text-red-600"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>`;
                c.appendChild(d);
            });
        } catch (e) { c.innerHTML = '<p class="text-red-500">Gagal memuat FAQ.</p>'; }
    }


    // --- FUNGSI UNTUK HALAMAN CHAT ---\
    let chatPolling;
    async function loadConversations() { 
        const list = document.getElementById('conversation-list'); 
        if(!list) return; 
        try { 
            const res = await fetch('../api/admin_get_conversations.php'); 
            const data = await res.json(); 
            list.innerHTML = ''; 
            data.conversations.forEach(c => { 
                const d = document.createElement('div'); 
                d.className = 'p-4 border-b border-slate-100 cursor-pointer hover:bg-slate-50'; 
                d.innerHTML = `<h4 class="font-bold text-sm">${escapeHTML(c.username)}</h4><p class="text-xs text-slate-500 truncate">${escapeHTML(c.last_message||'')}</p>`; 
                d.onclick = () => openChat(c.user_id, c.username); 
                list.appendChild(d); 
            }); 
        } catch (e) { console.error('Failed to load conversations:', e); } 
    }
    
    async function openChat(uid, name) { 
        clearInterval(chatPolling); 
        document.getElementById('current-user-id').value = uid; 
        document.getElementById('chat-placeholder').classList.add('hidden'); 
        document.getElementById('chat-content').classList.replace('hidden', 'flex'); 
        document.getElementById('chat-header').querySelector('h3').textContent = name; 
        await loadMessages(uid); 
        chatPolling = setInterval(() => loadMessages(uid, true), 3000); 
    }
    
    async function loadMessages(uid, isPolling = false) { 
        const msgContainer = document.getElementById('chat-messages'); 
        if(!msgContainer) return; 
        try { 
            const res = await fetch(`../api/admin_get_messages.php?user_id=${uid}`); 
            const data = await res.json(); 
            if (!isPolling) msgContainer.innerHTML = ''; 
            data.messages.forEach(m => { 
                const id = `msg-${m.id}`; 
                if (document.getElementById(id)) return; 
                const d = document.createElement('div'); 
                d.id = id; 
                d.className = m.sender === 'admin' ? 'flex justify-end' : 'flex justify-start'; 
                d.innerHTML = `<div class="max-w-[70%] ${m.sender === 'admin' ? 'bg-slate-800 text-white' : 'bg-slate-200 text-slate-800'} p-3 rounded-xl text-sm">${escapeHTML(m.message)}</div>`; 
                msgContainer.appendChild(d); 
            }); 
            if(!isPolling) msgContainer.scrollTop = msgContainer.scrollHeight; 
        } catch (e) { console.error('Failed to load messages:', e); } 
    }
    
    async function handleChatReply(e) { 
        e.preventDefault(); 
        const uid = document.getElementById('current-user-id').value; 
        const input = document.getElementById('reply-message-input'); 
        const msg = input.value.trim(); 
        if (!uid || !msg) return; 
        const btn = e.target.querySelector('button'); 
        btn.disabled = true; 
        try { 
            const res = await fetch('../api/admin_send_message.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ user_id: uid, message: msg }) }); 
            const result = await res.json(); 
            if (result.success) { 
                input.value = ''; 
                // Segera panggil loadMessages untuk menampilkan pesan terkirim
                await loadMessages(uid, true); 
                const msgContainer = document.getElementById('chat-messages');
                msgContainer.scrollTop = msgContainer.scrollHeight;
            } else { 
                throw new Error(result.message); 
            } 
        } catch (err) { 
            alert(`Error: ${err.message}`); 
        } finally { 
            btn.disabled = false; 
            input.focus(); 
        } 
    };

});


// =================================================================
// BAGIAN 4: FUNGSI UNTUK HALAMAN USERS (Dibuat Global)
// =================================================================
// Fungsi-fungsi ini harus ada di scope global agar bisa dipanggil oleh `onclick`
// di dalam HTML yang di-generate oleh PHP.

// ...dengan fungsi baru yang async ini:
async function impersonateUser(userId) {
    // Tampilkan dialog konfirmasi yang lebih tegas
    if (confirm(`Anda YAKIN ingin login sebagai user ID: ${userId}?\\n\\nSesi admin Anda akan berakhir dan Anda akan login sebagai user ini.`)) {
        try {
            // Kirim permintaan ke API impersonate yang baru kita buat
            const response = await fetch('../api/admin_impersonate.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ userId: userId })
            });

            const result = await response.json();

            if (result.success) {
                // Tampilkan pesan sukses dari API
                alert(result.message);
                
                // Arahkan browser ke URL yang diberikan oleh API (../index.php)
                window.location.href = result.redirectUrl;
            } else {
                // Jika API mengembalikan error, tampilkan dengan detail
                let errorMessage = result.error || 'Terjadi kesalahan yang tidak diketahui.';
                if (result.details) {
                    errorMessage += `\\n\\n[ DETAIL: ${result.details} ]`;
                }
                throw new Error(errorMessage);
            }
        } catch (error) {
            // Tangkap error jaringan atau error dari 'throw' di atas
            alert(`Gagal melakukan impersonasi: ${error.message}`);
        }
    }
}





// =================================================================
// ...DENGAN FUNGSI BARU YANG INI:
// =================================================================
// =================================================================
// GANTI LAGI FUNGSI `showSuspendModal` DENGAN VERSI INI:
// =================================================================
async function showSuspendModal(userId, currentStatus) {
    const action = currentStatus === 'active' ? 'suspend' : 'activate';
    const newStatus = currentStatus === 'active' ? 'suspended' : 'active';

    if (confirm(`Apakah Anda yakin ingin melakukan '${action}' pada user ID: ${userId}?`)) {
        try {
            const response = await fetch('../api/admin_update_user_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ userId: userId, newStatus: newStatus })
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);
                window.location.reload(); 
            } else {
                // --- PERUBAHAN UTAMA ADA DI SINI ---\
                // Buat pesan error yang lebih detail
                let errorMessage = result.error || 'Terjadi kesalahan yang tidak diketahui.';
                
                // Jika API memberikan 'details', tambahkan ke pesan.
                if (result.details) {
                    errorMessage += `\\n\\n[ DETAIL TEKNIS: ${result.details} ]`;
                }
                
                throw new Error(errorMessage);
                // --- AKHIR PERUBAHAN ---\
            }

        } catch (error) {
            alert(`Gagal memperbarui status: ${error.message}`);
        }
    }
}



// =================================================================
// GANTI FUNGSI LAMA INI...\
// =================================================================
/*
function showExpiryModal(userId) { 
    console.log(`TODO: Bangun UI/modal untuk set expiry date user ${userId}.`); 
}
*/


// =================================================================
// ...DENGAN FUNGSI BARU YANG INI:
// =================================================================
// =================================================================
// GANTI FUNGSI LAMA DENGAN VERSI BARU INI
// =================================================================
// FUNGSI BARU UNTUK MODAL KALENDER
async function showExpiryModal(userId) {
    // Ambil elemen-elemen modal dari HTML yang baru kita tambahkan
    const modal = document.getElementById('expiry-modal');
    const userIdDisplay = document.getElementById('expiry-user-id-display');
    const datePickerInput = document.getElementById('expiry-date-picker');
    const saveBtn = document.getElementById('expiry-save-btn');
    const cancelBtn = document.getElementById('expiry-cancel-btn');

    // Tampilkan User ID di modal dan tampilkan modalnya
    userIdDisplay.textContent = `#${userId}`;
    modal.classList.remove('hidden');

    // Inisialisasi kalender Flatpickr pada input field
    const fp = flatpickr(datePickerInput, {
        dateFormat: "Y-m-d", // Format untuk dikirim ke database
        altInput: true,      // Tampilkan format yang lebih ramah pengguna
        altFormat: "j F Y",  // Format ramah pengguna (e.g., 17 August 2024)
        defaultDate: "today" // Default ke tanggal hari ini
    });

    // Buat \"listener\" yang menunggu aksi dari user (klik Simpan atau Batal)
    const userActionPromise = new Promise(resolve => {
        saveBtn.onclick = () => resolve('save');
        cancelBtn.onclick = () => resolve('cancel');
        
        // Jika user klik di area latar belakang modal, anggap sebagai \"Batal\"\
        modal.addEventListener('click', (e) => {
            if (e.target.id === 'expiry-modal') {
                resolve('cancel');
            }
        });
    });

    // Tunggu sampai user melakukan aksi
    const action = await userActionPromise;

    if (action === 'save') {
        const newDate = datePickerInput.value;

        if (!newDate) {
            alert("Harap pilih tanggal terlebih dahulu.");
        } else {
            try {
                // Kirim data ke API (logika ini sama seperti sebelumnya)
                const response = await fetch('../api/admin_update_user_expiry.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ userId: userId, newExpiryDate: newDate })
                });
                const result = await response.json();
                if (result.success) {
                    alert(result.message);
                    window.location.reload();
                } else {
                    let errorMessage = result.error || 'Terjadi kesalahan.';
                    if (result.details) errorMessage += `\\n\\n[ DETAIL: ${result.details} ]`;
                    throw new Error(errorMessage);
                }
            } catch (error) {
                alert(`Gagal memperbarui tanggal: ${error.message}`);
            }
        }
    }

    // Apapun aksinya (simpan atau batal), hancurkan instance kalender & sembunyikan modal
    fp.destroy();
    modal.classList.add('hidden');
}





// =================================================================
// PENGGANTI FUNGSI viewUserLogs (LANGKAH FINAL)
// =================================================================
async function viewUserLogs(userId) {
    // 1. Dapatkan semua elemen HTML yang kita butuhkan dari modal
    const modal = document.getElementById('logs-modal');
    const contentDiv = document.getElementById('logs-content');
    const userInfo = document.getElementById('logs-user-info');
    const closeBtn = document.getElementById('close-logs-modal-btn');

    // Berhenti jika ada elemen yang tidak ditemukan
    if (!modal || !contentDiv || !userInfo || !closeBtn) {
        alert('Error: Elemen modal log tidak ditemukan. Coba refresh halaman.');
        return;
    }

    // 2. Tampilkan modal dan pasang status \"loading\"\
    modal.classList.remove('hidden');
    contentDiv.innerHTML = '<p class="text-center text-slate-400 animate-pulse">Memuat riwayat log...</p>';
    userInfo.textContent = `Memuat info untuk User ID: #${userId}...`;

    // 3. Siapkan fungsi untuk menutup modal (saat tombol 'X' atau area luar diklik)
    const closeModal = () => modal.classList.add('hidden');
    closeBtn.onclick = closeModal;
    modal.addEventListener('click', (e) => {
        if (e.target.id === 'logs-modal') {
            closeModal();
        }
    });

    try {
        // 4. Panggil API yang sudah kita buat untuk mengambil data
        const response = await fetch(`../api/admin_get_user_logs.php?user_id=${userId}`);
        const data = await response.json();

        // Jika respons gagal atau API mengembalikan error, lempar error
        if (!response.ok || !data.success) {
            throw new Error(data.error || 'Gagal mengambil data dari server.');
        }

        // 5. Update header modal dengan username dan email
        userInfo.textContent = `${data.user.username} (${data.user.email})`;
        
        // 6. Bersihkan area konten dan mulai tampilkan log
        contentDiv.innerHTML = '';

        if (data.logs.length === 0) {
            // Tampilkan pesan jika tidak ada log
            contentDiv.innerHTML = '<p class="text-center text-slate-500">Tidak ada aktivitas log yang tercatat untuk pengguna ini.</p>';
        } else {
            // Buat kontainer untuk daftar log
            const logList = document.createElement('div');
            logList.className = 'space-y-4'; // Beri jarak antar entri

            // Loop melalui setiap data log dan buat elemen HTML-nya
            data.logs.forEach(log => {
                const logEntry = document.createElement('div');
                logEntry.className = 'flex items-start text-sm';

                // Format tanggal dan waktu agar lebih mudah dibaca
                const ts = new Date(log.timestamp);
                const formattedDate = ts.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                const formattedTime = ts.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                // Isi konten untuk setiap entri log
                logEntry.innerHTML = `
                    <div class="w-28 flex-shrink-0 text-slate-400 text-xs text-right pr-4">
                        <div>${formattedDate}</div>
                        <div>${formattedTime}</div>
                    </div>
                    <div class="flex-shrink-0 relative">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mt-1"></div>
                        <div class="absolute top-3 left-1/2 w-px h-full bg-slate-200 -translate-x-1/2"></div>
                    </div>
                    <div class="flex-grow pl-4 pb-4">
                        <p class="font-bold text-slate-700 capitalize">${log.action.replace(/_/g, ' ').replace('success', '')}</p>
                        <p class="text-xs text-slate-500">IP Address: ${log.ip_address || 'N/A'}</p>
                        ${log.details ? `<pre class="mt-1 text-xs bg-slate-50 p-2 rounded-lg w-full overflow-x-auto">${log.details}</pre>` : ''}
                    </div>
                `;
                logList.appendChild(logEntry);
            });
            contentDiv.appendChild(logList);
        }

    } catch (error) {
        // 7. Jika terjadi error di `try` block, tampilkan pesan error di modal
        contentDiv.innerHTML = `<div class="p-4 bg-red-100 text-red-700 rounded-lg"><strong>Error:</strong> ${error.message}</div>`;
    }
}

</script>

</body>
</html>
