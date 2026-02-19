<?php
// web_dashboard/settings.php
session_start();
require_once 'components/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$msg = "";

// PROSES SIMPAN DATA
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone_number']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Cek duplikasi email (kecuali punya sendiri)
    $stmtCek = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmtCek->execute([$email, $user_id]);
    if ($stmtCek->fetch()) {
        $msg = "Email sudah digunakan user lain!";
    } else {
        // Update Data Dasar
        $sql = "UPDATE users SET full_name = ?, phone_number = ?, email = ? WHERE id = ?";
        $params = [$full_name, $phone, $email, $user_id];
        
        // Update Password jika diisi
        if (!empty($password)) {
            $sql = "UPDATE users SET full_name = ?, phone_number = ?, email = ?, password = ? WHERE id = ?";
            $params = [$full_name, $phone, $email, password_hash($password, PASSWORD_DEFAULT), $user_id];
        }

        $stmt = $pdo->prepare($sql);
        if ($stmt->execute($params)) {
            $_SESSION['email'] = $email; // Update session
            echo "<script>alert('✅ Profil berhasil diperbarui!'); window.location='easy.php';</script>";
        } else {
            $msg = "Gagal menyimpan data.";
        }
    }
}

// AMBIL DATA USER
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$u = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen p-6">

    <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Edit Profil</h2>
            <a href="easy.php" class="text-sm font-bold text-slate-400 hover:text-slate-600">Kembali</a>
        </div>

        <?php if($msg): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-xs font-bold text-center"><?= $msg ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Username (Tidak bisa diubah)</label>
                <input type="text" value="<?= htmlspecialchars($u['username']) ?>" class="w-full border border-slate-200 bg-slate-100 text-slate-500 rounded-xl p-3 text-sm" disabled>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="full_name" value="<?= htmlspecialchars($u['full_name'] ?? '') ?>" class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:border-blue-500 outline-none transition" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">No. WhatsApp</label>
                    <input type="text" name="phone_number" value="<?= htmlspecialchars($u['phone_number'] ?? '') ?>" class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:border-blue-500 outline-none transition" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($u['email'] ?? '') ?>" class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:border-blue-500 outline-none transition" required>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Ganti Password (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti" class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:border-blue-500 outline-none transition">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                SIMPAN PERUBAHAN
            </button>
        </form>
    </div>

</body>
</html>