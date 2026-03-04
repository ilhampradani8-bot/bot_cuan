<?php
// FILE: web_dashboard/admin/pages/chat.php
// Konten untuk halaman live chat.
?>
<header>
    <h1 class="text-3xl font-bold leading-tight text-slate-900">Live Chat</h1>
</header>

<div id="live-chat-view" class="mt-8 bg-white shadow-lg rounded-xl border border-slate-200 h-[70vh] flex">
    <!-- Panel Kiri: Daftar Percakapan -->
    <div class="w-1/3 border-r border-slate-200 flex flex-col">
        <div class="p-4 border-b border-slate-200">
            <h2 class="text-lg font-semibold">Conversations</h2>
        </div>
        <div id="conversation-list" class="flex-1 overflow-y-auto">
            <!-- Percakapan dimuat oleh JS -->
        </div>
    </div>
    
    <!-- Panel Kanan: Jendela Chat -->
    <div id="chat-window" class="w-2/3 flex flex-col bg-white rounded-r-xl overflow-hidden h-full">
        <!-- Placeholder saat belum ada chat dipilih -->
        <div id="chat-placeholder" class="flex flex-col items-center justify-center h-full text-slate-400 bg-slate-50/50">
            <svg class="w-16 h-16 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            <p class="mt-4 text-sm font-medium">Pilih percakapan untuk membalas</p>
        </div>

        <!-- Konten Chat Aktif -->
        <div id="chat-content" class="hidden flex-1 flex flex-col h-full overflow-hidden">
            <div id="chat-header" class="p-4 border-b border-slate-100 bg-white flex items-center justify-between"><div class="flex items-center gap-3"><div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xs">U</div><h3 class="font-bold text-slate-800 tracking-tight"></h3></div><span class="text-[10px] px-2 py-1 bg-green-100 text-green-700 rounded-full font-bold uppercase tracking-wider">Live</span></div>
            <div id="chat-messages" class="flex-1 p-6 overflow-y-auto bg-slate-50/50 space-y-4 scroll-smooth min-h-0"></div>
            <div class="p-4 bg-white border-t border-slate-100">
                <form id="reply-form" class="relative">
                    <input type="hidden" id="current-user-id" value="">
                    <div class="flex items-center gap-2">
                        <input type="text" id="reply-message-input" placeholder="Tulis balasan profesional..." class="flex-1 w-full px-5 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" autocomplete="off" required>
                        <button type="submit" class="bg-blue-600 text-white w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all active:scale-95"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
