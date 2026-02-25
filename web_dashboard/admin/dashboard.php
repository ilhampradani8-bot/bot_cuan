<?php
// Start the session
session_start();

// --- Page Protection ---
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit;
}

// --- Logout Logic ---
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

    <!-- Admin Navigation Bar -->
    <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-8">
                    <span class="text-xl font-extrabold text-slate-900">Admin<span class="text-blue-600">.</span></span>
                    <!-- View Toggler Buttons -->
                    <!-- Cari di line 40-47 -->
                        <div class="flex items-center space-x-2">
                            <button id="show-users-btn" class="px-3 py-2 text-sm font-medium text-white bg-slate-800 rounded-md transition-all">User Management</button>
                            <!-- Tombol FAQ Baru -->
                            <button id="show-faq-btn" class="px-3 py-2 text-sm font-medium text-slate-600 bg-slate-200 rounded-md hover:bg-slate-300 transition-all">Manage FAQ</button>
                            <button id="show-chat-btn" class="px-3 py-2 text-sm font-medium text-slate-600 bg-slate-200 rounded-md hover:bg-slate-300 relative transition-all">
                                Live Chat
                                <span id="unread-chat-indicator" class="hidden absolute -top-1 -right-1 w-3 h-3 bg-red-500 border-2 border-white rounded-full"></span>
                            </button>
                        </div>

                </div>
                <div class="flex items-center">
                    <span class="text-sm text-slate-600 mr-4">Welcome, <strong><?= htmlspecialchars($_SESSION['admin_username']); ?></strong></span>
                    <a href="?action=logout" class="text-xs bg-red-500 text-white px-3 py-2 rounded-lg font-bold hover:bg-red-600 transition">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <!-- View 1: User Management (Visible by default) -->
        <div id="user-management-view">
            <header>
                <h1 class="text-3xl font-bold leading-tight text-slate-900">User Management</h1>
            </header>
            <div class="mt-8">
                <?php
                require_once __DIR__ . '/../components/database.php';
                try {
                    $stmt = $pdo->query(
                        "SELECT u.id, u.username, u.email, bs.api_key 
                         FROM users u 
                         LEFT JOIN bot_settings bs ON u.id = bs.user_id 
                         ORDER BY u.id ASC"
                    );
                    $users = $stmt->fetchAll();
                } catch (PDOException $e) {
                    echo '<div class="p-4 bg-red-100 text-red-800 rounded-lg">Error fetching user data: ' . htmlspecialchars($e->getMessage()) . '</div>';
                    $users = [];
                }
                ?>
                <div class="bg-white shadow-lg rounded-xl border border-slate-200 overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-200">
                        <!-- Cari di file web_dashboard/admin/dashboard.php (Baris 83-113) -->
<thead class="bg-slate-50">
    <tr>
        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">User & Identity</th>
        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status Bayar</th>
        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Masa Aktif</th>
        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Akses Akun</th>
        <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
    </tr>
</thead>
<tbody class="bg-white divide-y divide-slate-200">
    <?php foreach ($users as $user): 
        // Logic status sederhana untuk demo, nanti sesuaikan dengan kolom DB Anda
        $is_expired = false; // logic: check expiry_date > now
        $is_banned = false;  // logic: check status column
    ?>
        <tr class="hover:bg-slate-50 transition-colors">
            <!-- User & Identity -->
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-slate-900"><?= htmlspecialchars($user['username']); ?></span>
                    <span class="text-xs text-slate-500"><?= htmlspecialchars($user['email']); ?></span>
                </div>
            </td>
            
            <!-- Status Pembayaran -->
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2.5 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-green-100 text-green-800 uppercase tracking-wider">Paid</span>
                <div class="text-[10px] text-slate-400 mt-1">Via: Bank Transfer</div>
            </td>

            <!-- Masa Aktif/Durasi -->
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex flex-col">
                    <span class="text-xs font-medium text-slate-700">30 Hari (Premium)</span>
                    <span class="text-[10px] text-red-500 font-bold">Exp: 2024-12-30</span>
                </div>
            </td>

            <!-- Akses Akun (Status Banned/Active) -->
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2.5 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-blue-100 text-blue-700 uppercase">Active</span>
            </td>

            <!-- Actions Buttons -->
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                <!-- Tombol Izinkan/Aktifkan -->
                <button onclick="updateAccess(<?= $user['id']; ?>, 'allow')" class="text-blue-600 hover:text-blue-900 p-1 bg-blue-50 rounded" title="Izinkan Akses">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </button>
                
                <!-- Tombol Blokir/Banned -->
                <button onclick="updateAccess(<?= $user['id']; ?>, 'block')" class="text-red-600 hover:text-red-900 p-1 bg-red-50 rounded" title="Blokir Akun">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                </button>

                <!-- Tombol Edit Sandi -->
                <button onclick="changePassword(<?= $user['id']; ?>)" class="text-slate-600 hover:text-slate-900 p-1 bg-slate-100 rounded" title="Ubah Sandi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- View 2: Live Chat (Hidden by default) -->
        <div id="live-chat-view" class="hidden">
             <header>
                <h1 class="text-3xl font-bold leading-tight text-slate-900">Live Chat</h1>
            </header>
            <div class="mt-8 bg-white shadow-lg rounded-xl border border-slate-200 h-[70vh] flex">
                <!-- Left Panel: Conversation List -->
                <div class="w-1/3 border-r border-slate-200 flex flex-col">
                    <div class="p-4 border-b border-slate-200">
                        <h2 class="text-lg font-semibold">Conversations</h2>
                    </div>
                    <div id="conversation-list" class="flex-1 overflow-y-auto">
                        <!-- Conversations will be loaded here by JS -->
                    </div>
                </div>
                <!-- Right Panel: Chat Window -->
                <!-- Cari div id="chat-window" sampai penutup form </form> dan </div> penutupnya -->
                <div id="chat-window" class="w-2/3 flex flex-col bg-white rounded-r-xl overflow-hidden h-full">
                    <!-- Placeholder: Shown when no user is selected -->
                    <div id="chat-placeholder" class="flex flex-col items-center justify-center h-full text-slate-400 bg-slate-50/50">
                        <svg class="w-16 h-16 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="mt-4 text-sm font-medium">Pilih percakapan untuk membalas</p>
                    </div>

                    <!-- Active Chat Content: Fixed height with internal scroll -->
                    <div id="chat-content" class="hidden flex-1 flex flex-col h-full overflow-hidden">
                        <!-- Header: Profile info -->
                        <div id="chat-header" class="p-4 border-b border-slate-100 bg-white flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xs">U</div>
                                <h3 class="font-bold text-slate-800 tracking-tight"></h3>
                            </div>
                            <span class="text-[10px] px-2 py-1 bg-green-100 text-green-700 rounded-full font-bold uppercase tracking-wider">Live</span>
                        </div>

                        <!-- Message List: This area scrolls automatically -->
                        <div id="chat-messages" class="flex-1 p-6 overflow-y-auto bg-slate-50/50 space-y-4 scroll-smooth min-h-0">
                            <!-- Messages will be injected here -->
                        </div>

                        <!-- Reply Input: Fixed at the bottom -->
                        <div class="p-4 bg-white border-t border-slate-100">
                            <form id="reply-form" class="relative">
                                <input type="hidden" id="current-user-id" value="">
                                <div class="flex items-center gap-2">
                                    <input type="text" id="reply-message-input" 
                                        placeholder="Tulis balasan profesional..." 
                                        class="flex-1 w-full px-5 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" 
                                        autocomplete="off" required>
                                    <button type="submit" class="bg-blue-600 text-white w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all active:scale-95">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>




        <!-- View 3: FAQ Management (Hidden by default) -->
<div id="faq-management-view" class="hidden">
    <header class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-slate-900">FAQ Management</h1>
        <button id="add-faq-modal-btn" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">+ Tambah FAQ</button>
    </header>
    
    <div id="faq-list-container" class="grid gap-4">
        <!-- FAQ items akan di-load di sini via JS -->
        <p class="text-slate-500 animate-pulse">Memuat daftar FAQ...</p>
    </div>
</div>

<!-- Simple Modal for Adding FAQ (Place before </body>) -->
<div id="faq-modal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-xl font-bold text-slate-800">Tambah Pertanyaan Baru</h3>
        </div>
        <form id="faq-form" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Pertanyaan</label>
                <input type="text" id="faq-question" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 outline-none" placeholder="Contoh: Bagaimana cara depo?" required>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Jawaban</label>
                <textarea id="faq-answer" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 outline-none" placeholder="Tulis jawaban lengkap..." required></textarea>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" id="close-faq-modal" class="flex-1 px-4 py-3 text-slate-500 font-bold hover:bg-slate-50 rounded-xl transition-all">Batal</button>
                <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all">Simpan FAQ</button>
            </div>
        </form>
    </div>
</div>


    </main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // === A. ELEMENTS ===
    const views = {
        users: document.getElementById('user-management-view'),
        chat: document.getElementById('live-chat-view'),
        faq: document.getElementById('faq-management-view')
    };
    const btns = {
        users: document.getElementById('show-users-btn'),
        chat: document.getElementById('show-chat-btn'),
        faq: document.getElementById('show-faq-btn')
    };
    
    // Modal FAQ Elements
    const faqModal = document.getElementById('faq-modal');
    const openFaqModalBtn = document.getElementById('add-faq-modal-btn');
    const closeFaqModalBtn = document.getElementById('close-faq-modal');
    const faqForm = document.getElementById('faq-form');

    // Chat Elements
    const chatBox = {
        list: document.getElementById('conversation-list'),
        msgContainer: document.getElementById('chat-messages'),
        input: document.getElementById('reply-message-input'),
        form: document.getElementById('reply-form'),
        currentId: document.getElementById('current-user-id')
    };

    let activePolling = null;

    // === B. CORE LOGIC: TOGGLE VIEW ===
    function toggleView(target) {
        // Stop any active polling first
        stopPolling();

        // Hide all & Reset colors
        Object.keys(views).forEach(key => {
            views[key].classList.add('hidden');
            btns[key].classList.replace('bg-slate-800', 'bg-slate-200');
            btns[key].classList.replace('text-white', 'text-slate-600');
        });

        // Show active & Set color
        views[target].classList.remove('hidden');
        btns[target].classList.replace('bg-slate-200', 'bg-slate-800');
        btns[target].classList.replace('text-slate-600', 'text-white');

        // Initial Load for each view
        if (target === 'chat') {
            loadConversations();
            startPollingConversations();
        } else if (target === 'faq') {
            loadAdminFAQs();
        }
    }

    // === C. CHAT FUNCTIONS ===
    async function loadConversations() {
        try {
            const res = await fetch('../api/admin_get_conversations.php');
            const data = await res.json();
            chatBox.list.innerHTML = '';
            data.conversations.forEach(convo => {
                const div = document.createElement('div');
                div.className = 'p-4 border-b border-slate-100 cursor-pointer hover:bg-slate-50';
                div.innerHTML = `<h4 class="font-bold text-sm">${escapeHTML(convo.username)}</h4><p class="text-xs text-slate-500 truncate">${escapeHTML(convo.last_message || '')}</p>`;
                div.onclick = () => openChat(convo.user_id, convo.username);
                chatBox.list.appendChild(div);
            });
        } catch (e) { console.error(e); }
    }

    async function openChat(uid, name) {
        chatBox.currentId.value = uid;
        document.getElementById('chat-placeholder').classList.add('hidden');
        document.getElementById('chat-content').classList.replace('hidden', 'flex');
        document.getElementById('chat-header').querySelector('h3').textContent = name;
        await loadMessages(uid);
        startPollingMessages(uid);
    }

    async function loadMessages(uid, isPolling = false) {
        try {
            const res = await fetch(`../api/admin_get_messages.php?user_id=${uid}`);
            const data = await res.json();
            if(!isPolling) chatBox.msgContainer.innerHTML = '';
            data.messages.forEach(msg => {
                const id = `msg-${new Date(msg.timestamp).getTime()}`;
                if (document.getElementById(id)) return;
                const div = document.createElement('div');
                div.id = id;
                div.className = msg.sender === 'admin' ? 'flex justify-end mb-4' : 'flex justify-start mb-4';
                div.innerHTML = `<div class="${msg.sender === 'admin' ? 'bg-slate-800 text-white' : 'bg-slate-200 text-slate-800'} p-3 rounded-xl text-sm">${escapeHTML(msg.message)}</div>`;
                chatBox.msgContainer.appendChild(div);
            });
            chatBox.msgContainer.scrollTop = chatBox.msgContainer.scrollHeight;
        } catch (e) { console.error(e); }
    }

    // === D. FAQ FUNCTIONS ===
    async function loadAdminFAQs() {
        const container = document.getElementById('faq-list-container');
        container.innerHTML = '<p class="text-slate-400 animate-pulse">Memuat FAQ...</p>';
        try {
            const res = await fetch('../api/admin_get_faqs.php');
            const data = await res.json();
            container.innerHTML = '';
            if(data.faqs.length === 0) container.innerHTML = '<p class="text-slate-500">Belum ada FAQ.</p>';
            data.faqs.forEach(f => {
                const div = document.createElement('div');
                div.className = 'p-4 bg-white border border-slate-200 rounded-xl shadow-sm';
                div.innerHTML = `<h4 class="font-bold text-slate-800">${escapeHTML(f.question)}</h4><p class="text-sm text-slate-600 mt-1">${escapeHTML(f.answer)}</p>`;
                container.appendChild(div);
            });
        } catch (e) { container.innerHTML = 'Gagal memuat FAQ.'; }
    }

    // Modal Events
    openFaqModalBtn.onclick = () => faqModal.classList.remove('hidden');
    closeFaqModalBtn.onclick = () => faqModal.classList.add('hidden');
    faqForm.onsubmit = async (e) => {
        e.preventDefault();
        const question = document.getElementById('faq-question').value;
        const answer = document.getElementById('faq-answer').value;
        try {
            const res = await fetch('../api/admin_add_faq.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ question, answer })
            });
            const data = await res.json();
            if(data.success) {
                faqModal.classList.add('hidden');
                faqForm.reset();
                loadAdminFAQs();
            }
        } catch (e) { alert('Gagal simpan FAQ'); }
    };

    // === E. UTILS & POLLING ===
    function startPollingConversations() { activePolling = setInterval(loadConversations, 5000); }
    function startPollingMessages(uid) { activePolling = setInterval(() => { loadMessages(uid, true); loadConversations(); }, 3000); }
    function stopPolling() { if(activePolling) clearInterval(activePolling); }
    function escapeHTML(s) { const p = document.createElement('p'); p.textContent = s; return p.innerHTML; }

    // Event Listeners for switching views
    btns.users.onclick = () => toggleView('users');
    btns.chat.onclick = () => toggleView('chat');
    btns.faq.onclick = () => toggleView('faq');





    // Fungsi untuk Blokir atau Izinkan Akses
async function updateAccess(userId, action) {
    if(!confirm(`Apakah Anda yakin ingin ${action === 'block' ? 'MEMBLOKIR' : 'MENGIZINKAN'} user ini?`)) return;
    
    try {
        const res = await fetch('../api/admin_update_user.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ user_id: userId, action: action })
        });
        const data = await res.json();
        if(data.success) location.reload(); // Refresh untuk melihat perubahan status
    } catch (e) { alert('Gagal memproses permintaan keamanan.'); }
}

// Fungsi Ubah Sandi (Prompt Sederhana)
async function changePassword(userId) {
    const newPass = prompt("Masukkan password baru untuk user ini:");
    if (!newPass) return;

    try {
        const res = await fetch('../api/admin_update_password.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ user_id: userId, new_password: newPass })
        });
        const data = await res.json();
        if(data.success) alert('Password berhasil diperbarui.');
    } catch (e) { alert('Gagal memperbarui password.'); }
}


});

</script>

</body>
</html>
