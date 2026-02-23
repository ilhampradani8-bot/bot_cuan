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
                    <div class="flex items-center space-x-2">
                        <button id="show-users-btn" class="px-3 py-2 text-sm font-medium text-white bg-slate-800 rounded-md">User Management</button>
                        <button id="show-chat-btn" class="px-3 py-2 text-sm font-medium text-slate-600 bg-slate-200 rounded-md hover:bg-slate-300">
                            Live Chat
                            <span id="unread-chat-indicator" class="hidden ml-1 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
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
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">User ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Username</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">API Key Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900"><?= htmlspecialchars($user['id']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700"><?= htmlspecialchars($user['username']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?= htmlspecialchars($user['email']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <?= !empty($user['api_key']) ? '<span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Connected</span>' : '<span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-600">Not Connected</span>'; ?>
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
                <div id="chat-window" class="w-2/3 flex flex-col">
                    <!-- Placeholder when no chat is selected -->
                    <div id="chat-placeholder" class="flex flex-col items-center justify-center h-full text-slate-500">
                         <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <h3 class="mt-4 text-lg font-semibold">Select a conversation</h3>
                        <p class="text-sm">Choose a user from the left panel to view messages.</p>
                    </div>
                    <!-- Actual chat content (hidden initially) -->
                    <div id="chat-content" class="hidden flex-1 flex flex-col">
                        <div id="chat-header" class="p-4 border-b border-slate-200 flex items-center">
                            <h3 class="font-bold text-slate-800"></h3>
                        </div>
                        <div id="chat-messages" class="flex-1 p-6 overflow-y-auto bg-slate-50">
                            <!-- Messages will be loaded here -->
                        </div>
                        <div class="p-4 bg-white border-t border-slate-200">
                            <form id="reply-form">
                                <div class="flex items-center gap-2">
                                    <input type="hidden" id="current-user-id" value="">
                                    <input type="text" id="reply-message-input" placeholder="Type your reply..." class="flex-1 w-full px-4 py-2 text-sm border border-slate-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off" required>
                                    <button type="submit" class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 hover:bg-blue-700">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- Elements ---
    const userView = document.getElementById('user-management-view');
    const chatView = document.getElementById('live-chat-view');
    const showUsersBtn = document.getElementById('show-users-btn');
    const showChatBtn = document.getElementById('show-chat-btn');
    const conversationList = document.getElementById('conversation-list');
    const chatPlaceholder = document.getElementById('chat-placeholder');
    const chatContent = document.getElementById('chat-content');
    const chatHeader = document.getElementById('chat-header').querySelector('h3');
    const chatMessages = document.getElementById('chat-messages');
    const replyForm = document.getElementById('reply-form');
    const currentUserIdInput = document.getElementById('current-user-id');
    const replyMessageInput = document.getElementById('reply-message-input');
    const unreadIndicator = document.getElementById('unread-chat-indicator');
    let activePolling; // To hold the setInterval ID

    // --- View Toggling ---
    function toggleView(show) {
        if (show === 'chat') {
            userView.classList.add('hidden');
            chatView.classList.remove('hidden');
            showUsersBtn.classList.replace('bg-slate-800', 'bg-slate-200');
            showUsersBtn.classList.replace('text-white', 'text-slate-600');
            showChatBtn.classList.replace('bg-slate-200', 'bg-slate-800');
            showChatBtn.classList.replace('text-slate-600', 'text-white');
            loadConversations();
            startPollingConversations(); // Start polling when chat is active
        } else {
            chatView.classList.add('hidden');
            userView.classList.remove('hidden');
            showChatBtn.classList.replace('bg-slate-800', 'bg-slate-200');
            showChatBtn.classList.replace('text-white', 'text-slate-600');
            showUsersBtn.classList.replace('bg-slate-200', 'bg-slate-800');
            showUsersBtn.classList.replace('text-slate-600', 'text-white');
            stopPolling(); // Stop polling when not in chat view
        }
    }

    showUsersBtn.addEventListener('click', () => toggleView('users'));
    showChatBtn.addEventListener('click', () => toggleView('chat'));

    // --- API Calls & UI Updates ---

    // Load list of conversations
    async function loadConversations() {
        try {
            const response = await fetch('../api/admin_get_conversations.php');
            const data = await response.json();
            if (!data.success) throw new Error(data.message);
            
            conversationList.innerHTML = ''; // Clear previous list
            let totalUnread = 0;

            if (data.conversations.length === 0) {
                conversationList.innerHTML = `<p class="text-center text-slate-500 p-4">No conversations yet.</p>`;
            }

            data.conversations.forEach(convo => {
                const unreadCount = parseInt(convo.unread_count, 10);
                if (unreadCount > 0) totalUnread++;

                const convoElement = document.createElement('div');
                convoElement.className = 'p-4 border-b border-slate-100 cursor-pointer hover:bg-slate-50';
                convoElement.dataset.userId = convo.user_id;
                convoElement.dataset.username = convo.username;
                convoElement.innerHTML = `
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-sm">${escapeHTML(convo.username)}</h4>
                        ${unreadCount > 0 ? `<span class="text-xs font-bold text-white bg-red-500 rounded-full px-2 py-0.5">${unreadCount}</span>` : ''}
                    </div>
                    <p class="text-xs text-slate-500 truncate mt-1">${escapeHTML(convo.last_message) || 'No messages yet'}</p>
                `;
                convoElement.addEventListener('click', () => openChat(convo.user_id, convo.username));
                conversationList.appendChild(convoElement);
            });

            // Update global unread indicator
            if (totalUnread > 0) {
                unreadIndicator.classList.remove('hidden');
            } else {
                unreadIndicator.classList.add('hidden');
            }

        } catch (error) {
            conversationList.innerHTML = `<p class="text-center text-red-500 p-4">Failed to load conversations.</p>`;
            console.error(error);
        }
    }

    // Load messages for a specific user
    async function openChat(userId, username) {
        currentUserIdInput.value = userId; // Set current user ID for the reply form
        chatPlaceholder.classList.add('hidden');
        chatContent.classList.remove('hidden');
        chatContent.classList.add('flex');
        chatHeader.textContent = username;
        chatMessages.innerHTML = `<p class="text-center text-slate-400">Loading messages...</p>`;

        // Highlight selected conversation
        document.querySelectorAll('#conversation-list > div').forEach(div => {
            div.classList.remove('bg-blue-50', 'border-l-4', 'border-blue-500');
            if (div.dataset.userId == userId) {
                div.classList.add('bg-blue-50', 'border-l-4', 'border-blue-500');
                // Remove unread badge visually immediately
                const badge = div.querySelector('span');
                if (badge) badge.style.display = 'none';
            }
        });
        
        await loadMessages(userId);
        startPollingMessages(userId); // Start polling for this specific chat
    }
    
    async function loadMessages(userId, isPolling = false) {
        try {
            const response = await fetch(`../api/admin_get_messages.php?user_id=${userId}`);
            const data = await response.json();
            if (!data.success) throw new Error(data.message);
            
            if (!isPolling) chatMessages.innerHTML = '';
            
            data.messages.forEach(msg => {
                // To prevent duplicates during polling, check if message already exists
                const messageId = `msg-${new Date(msg.timestamp).getTime()}`;
                if (document.getElementById(messageId)) return;

                const messageElement = document.createElement('div');
                messageElement.id = messageId;
                if (msg.sender === 'admin') {
                    messageElement.className = 'flex items-end justify-end gap-2 mb-4';
                    messageElement.innerHTML = `<div class="bg-slate-800 text-white p-3 rounded-lg rounded-br-none max-w-md"><p class="text-sm">${escapeHTML(msg.message)}</p></div>`;
                } else {
                    messageElement.className = 'flex items-end gap-2 mb-4';
                    messageElement.innerHTML = `<div class="bg-slate-200 p-3 rounded-lg rounded-bl-none max-w-md"><p class="text-sm text-slate-800">${escapeHTML(msg.message)}</p></div>`;
                }
                chatMessages.appendChild(messageElement);
            });

            // Scroll to bottom only on initial load or if user is near the bottom
             if (!isPolling || (chatMessages.scrollHeight - chatMessages.scrollTop - chatMessages.clientHeight < 100)) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

        } catch (error) {
            chatMessages.innerHTML = `<p class="text-center text-red-500 p-4">Failed to load messages.</p>`;
            console.error(error);
        }
    }

    // Send a reply
    replyForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const userId = currentUserIdInput.value;
        const message = replyMessageInput.value.trim();

        if (!userId || !message) return;

        // Add message to UI immediately for responsiveness
        const tempMessageElement = document.createElement('div');
        tempMessageElement.className = 'flex items-end justify-end gap-2 mb-4';
        tempMessageElement.innerHTML = `<div class="bg-slate-800 text-white p-3 rounded-lg rounded-br-none max-w-md"><p class="text-sm">${escapeHTML(message)}</p></div>`;
        chatMessages.appendChild(tempMessageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        replyMessageInput.value = ''; // Clear input

        try {
            const response = await fetch('../api/admin_send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: userId, message: message })
            });
            const data = await response.json();
            if (!data.success) {
                // If sending failed, show an error and remove the temp message
                tempMessageElement.remove();
                alert('Failed to send message.');
                replyMessageInput.value = message; // Restore message
            }
            // On success, no need to do anything, the message is already in the UI.
            // We can refresh the conversation list to update the 'last message'
            loadConversations();
        } catch (error) {
            tempMessageElement.remove();
            alert('Failed to send message.');
            replyMessageInput.value = message;
            console.error(error);
        }
    });

    // --- Polling ---
    function startPollingConversations() {
        stopPolling(); // Ensure no other poll is running
        activePolling = setInterval(loadConversations, 5000); // Refresh conversation list every 5 seconds
    }
    
    function startPollingMessages(userId) {
        stopPolling(); // Stop the conversation list poll
        activePolling = setInterval(() => {
            loadMessages(userId, true); // Poll for new messages in the active chat
            loadConversations(); // Also poll conversations for the global unread count
        }, 3000); // Refresh every 3 seconds
    }

    function stopPolling() {
        if (activePolling) {
            clearInterval(activePolling);
            activePolling = null;
        }
    }

    // --- Utility ---
    function escapeHTML(str) {
        const p = document.createElement('p');
        p.appendChild(document.createTextNode(str));
        return p.innerHTML;
    }
});
</script>

</body>
</html>
