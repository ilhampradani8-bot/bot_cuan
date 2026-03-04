<?php
// FILE: web_dashboard/admin/pages/users.php
// Konten untuk halaman manajemen user, sekarang dengan fungsi pencarian.
?>

<!-- Bagian 1: Header Halaman -->
<header class="mb-8">
    <h1 class="text-3xl font-bold leading-tight text-slate-900">User Control Center</h1>
    <p class="text-sm text-slate-500">Manage user subscriptions, access, logs, and search for specific users.</p>
</header>

<!-- Bagian 2: Form Pencarian -->
<div class="mb-6">
    <form method="GET" action="dashboard.php" class="relative">
        <!-- Input tersembunyi untuk memastikan kita tetap di halaman 'users' saat mencari -->
        <input type="hidden" name="page" value="users">
        
        <label for="user-search" class="sr-only">Search users</label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
            </div>
            <input 
                type="search" 
                name="search" 
                id="user-search" 
                class="block w-full rounded-xl border border-slate-200 bg-white p-4 pl-11 text-slate-800 placeholder-slate-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                placeholder="Cari berdasarkan username atau email..."
                value="<?= htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES); ?>"
            >
        </div>
        <!-- Tombol submit bisa ditambahkan jika perlu, tapi biasanya Enter sudah cukup
        <button type="submit" class="absolute right-2.5 bottom-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Search</button>
        -->
    </form>
</div>


<?php
// Bagian 3: Logika PHP untuk Mengambil Data User
require_once __DIR__ . '/../../components/database.php'; // Menggunakan path absolut yang andal

// Ambil query pencarian jika ada
$search_query = $_GET['search'] ?? '';

try {
    // Siapkan query dasar
    $sql = "SELECT id, username, email, status, expired_at, last_login FROM users";
    
    // Jika ada query pencarian, tambahkan kondisi WHERE
    if (!empty($search_query)) {
        // Gunakan LIKE untuk pencarian parsial di kolom username dan email
        $sql .= " WHERE username LIKE :search OR email LIKE :search";
    }
    
    $sql .= " ORDER BY id ASC";
    
    // Persiapkan statement
    $stmt = $pdo->prepare($sql);
    
    // Bind parameter jika ada pencarian
    if (!empty($search_query)) {
        $search_term = '%' . $search_query . '%';
        $stmt->bindParam(':search', $search_term, PDO::PARAM_STR);
    }
    
    // Eksekusi dan ambil hasil
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo '<div class="p-4 bg-red-100 text-red-800 rounded-lg">Error fetching user data: ' . htmlspecialchars($e->getMessage()) . '</div>';
    $users = [];
}
?>

<!-- Bagian 4: Tampilan Daftar User -->
<div class="space-y-6">
    <?php if (empty($users)): ?>
        <div class="text-center py-10">
            <i class="fa-solid fa-user-slash text-4xl text-slate-300"></i>
            <p class="mt-4 text-slate-500">
                <?php if (!empty($search_query)): ?>
                    Tidak ada user yang cocok dengan pencarian "<strong><?= htmlspecialchars($search_query); ?></strong>".
                <?php else: ?>
                    Tidak ada user yang ditemukan di database.
                <?php endif; ?>
            </p>
        </div>
    <?php else: ?>
        <?php foreach ($users as $user): 
            // Logika untuk warna status
            $status_class = 'bg-gray-100 text-gray-800';
            if ($user['status'] === 'active') $status_class = 'bg-green-100 text-green-800';
            if ($user['status'] === 'suspended') $status_class = 'bg-yellow-100 text-yellow-800';
            if ($user['status'] === 'banned') $status_class = 'bg-red-100 text-red-800';
        ?>
        <!-- Kartu User -->
        <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 transition-all hover:shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                <!-- Info User -->
                <div class="md:col-span-3">
                    <h3 class="font-bold text-lg text-slate-800"><?= htmlspecialchars($user['username']); ?></h3>
                    <p class="text-sm text-slate-500"><?= htmlspecialchars($user['email']); ?></p>
                    <p class="text-xs text-slate-400 mt-1">User ID: <?= $user['id']; ?></p>
                </div>
                <!-- Status -->
                <div class="md:col-span-2 text-center">
                    <span class="px-3 py-1 text-xs font-bold rounded-full <?= $status_class; ?> uppercase tracking-wider"><?= htmlspecialchars($user['status']); ?></span>
                </div>
                <!-- Detail Langganan -->
                <div class="md:col-span-3">
                    <p class="text-sm font-semibold text-slate-700">Expires on: <span class="font-bold text-blue-600"><?= $user['expired_at'] ? date('d M Y', strtotime($user['expired_at'])) : 'N/A'; ?></span></p>
                    <p class="text-xs text-slate-400">Last login: <?= $user['last_login'] ? date('d M Y, H:i', strtotime($user['last_login'])) : 'Never'; ?></p>
                </div>
                <!-- Tombol Aksi -->
                <div class="md:col-span-4 flex items-center justify-end space-x-2">
                    <button onclick="impersonateUser(<?= $user['id']; ?>)" class="px-3 py-2 text-sm font-semibold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition" title="Login as this user"><i class="fa-solid fa-user-secret"></i> Login As</button>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="px-3 py-2 text-sm font-semibold text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition">More <i class="fa-solid fa-chevron-down text-xs"></i></button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-10 py-1 border border-slate-200" style="display: none;">
                            <a href="#" onclick="showSuspendModal(<?= $user['id']; ?>, '<?= $user['status']; ?>')" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Suspend/Activate</a>
                            <a href="#" onclick="showExpiryModal(<?= $user['id']; ?>)" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Set Expiry Date</a>
                            <a href="#" onclick="viewUserLogs(<?= $user['id']; ?>)" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">View Logs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
