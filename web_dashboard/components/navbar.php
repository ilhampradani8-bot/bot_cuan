<?php
// components/navbar.php
$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? ($_SESSION['username'] ?? 'User') : 'Guest';
?>

<nav class="bg-white w-full z-40 border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <a href="index.php" class="text-2xl font-bold text-slate-800">Trading<span class="text-blue-600">Safe</span>.</a>
            </div>
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    <a href="index.php" class="text-slate-600 hover:bg-slate-100 hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium">Beranda</a>
                    <a href="index.php#fitur" class="text-slate-600 hover:bg-slate-100 hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium">Fitur</a>
                    <a href="index.php#harga" class="text-slate-600 hover:bg-slate-100 hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium">Harga</a>
                    <?php if ($is_logged_in): ?>
                        <a href="dashboard.php" class="bg-blue-100 text-blue-700 px-3 py-2 rounded-md text-sm font-bold">Dashboard Saya</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex items-center">
                <?php if ($is_logged_in): ?>
                     <span class="text-sm text-slate-600 mr-4">Halo, <strong><?= htmlspecialchars($username) ?></strong>!</span>
                     <a href="?action=logout" class="bg-slate-200 text-slate-700 hover:bg-slate-300 px-3 py-2 rounded-md text-xs font-bold">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="bg-slate-800 text-white hover:bg-slate-900 px-4 py-2 rounded-md text-sm font-bold">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<?php if ($is_logged_in): ?>
<!-- === NEW Live Chat System === -->
<div id="chat-system-container" class="fixed bottom-5 right-5 z-50">
    <!-- Main Chat Window -->
    <div id="chat-window" class="hidden w-80 h-[28rem] bg-white rounded-xl shadow-2xl border border-slate-200 flex-col mb-2">
        
        <!-- View 1: Main Menu -->
                <!-- View 1: Main Menu -->
        <div id="chat-view-menu" class="flex flex-col h-full">
    <!-- Header for the menu view -->
    <div class="p-4 bg-slate-800 text-white rounded-t-xl text-center">
        <h3 class="font-bold text-sm">Butuh Bantuan?</h3>
    </div>
    <!-- Container for the menu options -->
    <div class="flex-1 p-3 flex flex-col justify-center gap-3">
        <!-- Button to show FAQ/Bot view -->
        <button id="show-faq-btn" class="w-full text-left p-4 bg-slate-100 hover:bg-slate-200 rounded-lg transition-all flex items-center gap-4">
            <div class="flex-shrink-0 w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-800">Tanya Bot (FAQ)</h4>
                <p class="text-xs text-slate-500">Jawaban cepat untuk pertanyaan umum.</p>
            </div>
        </button>
        <!-- Button to start a live chat session -->
        <button id="start-live-chat-btn" class="w-full text-left p-4 bg-slate-100 hover:bg-slate-200 rounded-lg transition-all flex items-center gap-4">
             <div class="flex-shrink-0 w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2V7a2 2 0 012-2h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V8z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-800">Chat dengan CS</h4>
                <p class="text-xs text-slate-500">Bicara langsung dengan tim support.</p>
            </div>
        </button>
        <!-- Link to the new tutorial page -->
        <a href="tutorial.php" class="block w-full text-left p-4 bg-slate-100 hover:bg-slate-200 rounded-lg transition-all flex items-center gap-4">
             <div class="flex-shrink-0 w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-800">Dokumentasi</h4>
                <p class="text-xs text-slate-500">Pelajari cara kerja fitur kami.</p>
            </div>
        </a>
    </div>
</div>



        <!-- View 2: Live Chat -->
        <div id="chat-view-live" class="hidden h-full flex-col">
            <div class="p-3 bg-slate-800 text-white rounded-t-xl flex items-center gap-3">
                <button id="back-to-menu-btn" class="text-slate-300 hover:text-white">&larr; Kembali</button>
                <h3 class="font-bold text-sm text-center flex-1">Live Chat Support</h3>
            </div>
            <div id="chat-body" class="flex-1 p-3 overflow-y-auto bg-slate-50"></div>
            <div class="p-2 border-t border-slate-200 bg-white rounded-b-xl">
                <form id="chat-form" class="flex items-center gap-2">
                    <input type="text" id="chat-message-input" placeholder="Ketik pesan..." class="w-full text-sm border-slate-300 rounded-full focus:ring-blue-500 focus:border-blue-500" required autocomplete="off">
                    <button type="submit" class="w-9 h-9 bg-blue-600 text-white rounded-full flex items-center justify-center flex-shrink-0 hover:bg-blue-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- View 3: FAQ -->
        <div id="chat-view-faq" class="hidden h-full flex-col">
            <div class="p-3 bg-slate-800 text-white rounded-t-xl flex items-center gap-3">
                <button id="faq-back-to-menu-btn" class="text-slate-300 hover:text-white">&larr; Kembali</button>
                <h3 class="font-bold text-sm text-center flex-1">Tanya Bot (FAQ)</h3>
            </div>
            <div id="faq-body" class="flex-1 p-3 overflow-y-auto">
                <p class="text-center text-slate-500 text-sm p-4">Fitur ini sedang dalam pengembangan.</p>
            </div>
        </div>

    </div>
    
    <!-- Chat Bubble -->
    <button id="chat-bubble" class="w-14 h-14 bg-blue-600 rounded-full shadow-lg flex items-center justify-center text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform hover:scale-110">
        <svg id="chat-icon-open" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
        <svg id="chat-icon-close" class="hidden w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- Elements ---
    const chatBubble = document.getElementById('chat-bubble');
    const chatWindow = document.getElementById('chat-window');
    const iconOpen = document.getElementById('chat-icon-open');
    const iconClose = document.getElementById('chat-icon-close');

    const viewMenu = document.getElementById('chat-view-menu');
    const viewLiveChat = document.getElementById('chat-view-live');
    const viewFAQ = document.getElementById('chat-view-faq');

    const showFaqBtn = document.getElementById('show-faq-btn');
    const startLiveChatBtn = document.getElementById('start-live-chat-btn');
    const backToMenuBtn = document.getElementById('back-to-menu-btn');
    const faqBackToMenuBtn = document.getElementById('faq-back-to-menu-btn');
    
    // --- Live Chat Specific Elements ---
    const chatBody = document.getElementById('chat-body');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('chat-message-input');
    let chatPolling;

    // --- State Management ---
    function showView(viewName) {
        viewMenu.classList.add('hidden');
        viewLiveChat.classList.add('hidden', 'flex-col');
        viewFAQ.classList.add('hidden', 'flex-col');
        viewLiveChat.classList.remove('flex');
        viewFAQ.classList.remove('flex');

        if(viewName === 'menu') {
            viewMenu.classList.remove('hidden');
        } else if (viewName === 'live') {
            viewLiveChat.classList.remove('hidden');
            viewLiveChat.classList.add('flex');
        } else if (viewName === 'faq') {
            viewFAQ.classList.remove('hidden');
            viewFAQ.classList.add('flex');
        }
    }

    // --- Event Listeners ---
    chatBubble.addEventListener('click', () => {
        const isOpening = chatWindow.classList.toggle('hidden');
        chatWindow.classList.toggle('flex');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
        
        if (isOpening) { // If it was just closed
            stopPolling();
        } else { // If it was just opened
            showView('menu'); // Always start at menu
        }
    });

    backToMenuBtn.addEventListener('click', () => showView('menu'));
    faqBackToMenuBtn.addEventListener('click', () => showView('menu'));

    showFaqBtn.addEventListener('click', () => {
        showView('faq');
        // Nanti kita akan panggil fungsi untuk load FAQ di sini
    });

    startLiveChatBtn.addEventListener('click', () => {
        showView('live');
        // Di sini nanti kita akan implementasikan logika "menunggu CS"
        // Untuk sekarang, kita langsung load chat yang sudah ada
        loadMessages();
        startPolling();
    });

    // --- (Existing Live Chat Logic - Adapted) ---
    async function loadMessages(isPolling = false) { /* ... (fungsi sama seperti sebelumnya) ... */ }
    chatForm.addEventListener('submit', async (e) => { /* ... (fungsi sama seperti sebelumnya) ... */ });
    function createMessageElement(sender, message, id) { /* ... (fungsi sama seperti sebelumnya) ... */ }
    function startPolling() { /* ... (fungsi sama seperti sebelumnya) ... */ }
    function stopPolling() { /* ... (fungsi sama seperti sebelumnya) ... */ }
    function escapeHTML(str) { /* ... (fungsi sama seperti sebelumnya) ... */ }
    
    // --> Salin semua fungsi live-chat dari kode sebelumnya ke sini <--
    // [ TEMPEL FUNGSI-FUNGSI INI DARI KODE LAMA ANDA ]
    // async function loadMessages(isPolling = false) { ... }
    // chatForm.addEventListener('submit', async (e) => { ... });
    // function createMessageElement(sender, message, id) { ... }
    // function startPolling() { ... }
    // function stopPolling() { ... }
    // function escapeHTML(str) { ... }
    
    async function loadMessages(isPolling = false) {
        try {
            const response = await fetch('api/get_messages.php'); 
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();
            if (!data.success) throw new Error(data.message);
            
            if (!isPolling) chatBody.innerHTML = '';

            data.messages.forEach(msg => {
                const messageId = `msg-user-${new Date(msg.timestamp).getTime()}`;
                if (document.getElementById(messageId)) return;
                const messageElement = createMessageElement(msg.sender, msg.message, messageId);
                chatBody.appendChild(messageElement);
            });

            if (!isPolling || (chatBody.scrollHeight - chatBody.scrollTop - chatBody.clientHeight < 100)) {
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        } catch (error) {
            console.error('Failed to load messages:', error);
            if (!isPolling) chatBody.innerHTML = '<p class="text-xs text-center text-red-500">Gagal memuat pesan.</p>';
        }
    }

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;

        const tempId = `msg-user-temp-${Date.now()}`;
        const tempMessageElement = createMessageElement('user', message, tempId);
        chatBody.appendChild(tempMessageElement);
        chatBody.scrollTop = chatBody.scrollHeight;
        messageInput.value = '';

        try {
            const response = await fetch('api/send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: message })
            });
            const data = await response.json();
            
            if (!data.success) {
                tempMessageElement.remove();
                messageInput.value = message;
                alert('Gagal mengirim pesan: ' + (data.message || 'Unknown error'));
            } else {
                tempMessageElement.remove();
                loadMessages(true);
            }
        } catch (error) {
            tempMessageElement.remove();
            messageInput.value = message;
            alert('Gagal mengirim pesan.');
        }
    });

    function createMessageElement(sender, message, id) {
        const div = document.createElement('div');
        div.id = id;
        if (sender === 'user') {
            div.className = 'flex justify-end mb-2';
            div.innerHTML = `<div class="bg-blue-600 text-white rounded-lg rounded-br-none py-2 px-3 max-w-xs"><p class="text-sm">${escapeHTML(message)}</p></div>`;
        } else { // admin
            div.className = 'flex justify-start mb-2';
            div.innerHTML = `<div class="bg-slate-200 text-slate-800 rounded-lg rounded-bl-none py-2 px-3 max-w-xs"><p class="text-sm">${escapeHTML(message)}</p></div>`;
        }
        return div;
    }
    
    function startPolling() {
        stopPolling();
        chatPolling = setInterval(() => loadMessages(true), 3000);
    }

    function stopPolling() {
        if (chatPolling) clearInterval(chatPolling);
    }

    function escapeHTML(str) {
        const p = document.createElement('p');
        p.appendChild(document.createTextNode(str));
        return p.innerHTML;
    }
});
</script>
<?php endif; ?>
