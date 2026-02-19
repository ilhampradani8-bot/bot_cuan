<?php
session_start();
require_once 'components/database.php';

// Pastikan user akses dari forgot.php
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot.php");
    exit;
}

$email = $_SESSION['reset_email'];
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code']);
    $new_pass = $_POST['new_password'];

    // 1. Cek kecocokan Kode & Email
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND verify_token = ?");
    $stmt->execute([$email, $code]);
    $user = $stmt->fetch();

    if ($user) {
        // 2. Hash Password Baru
        $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

        // 3. Update Password & Hapus Token (Biar kode gak bisa dipake 2x)
        $update = $pdo->prepare("UPDATE users SET password = ?, verify_token = NULL WHERE id = ?");
        $update->execute([$hashed_password, $user['id']]);

        // Hapus session reset
        unset($_SESSION['reset_email']);

        echo "<script>alert('✅ Password Berhasil Diubah! Silakan Login.'); window.location='login.php';</script>";
        exit;
    } else {
        $msg = "Kode Salah! Cek email Anda lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Password Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full border border-slate-100">
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Password Baru</h2>
            <p class="text-xs text-slate-400 mt-1">Akun: <b><?= htmlspecialchars($email) ?></b></p>
        </div>

        <?php if($msg): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-xs font-bold text-center">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kode Verifikasi (6 Digit)</label>
                <input type="text" name="code" placeholder="123456" class="w-full text-center text-xl tracking-widest border border-slate-200 rounded-xl p-3 outline-none focus:border-blue-500 transition" maxlength="6" required>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password Baru</label>
                <input type="password" name="new_password" class="w-full border border-slate-200 rounded-xl p-3 outline-none focus:border-blue-500 transition" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                SIMPAN PASSWORD
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="forgot.php" class="text-xs text-slate-400 hover:text-red-600">Bukan email ini? Ganti Email</a>
        </div>
    </div>

</body>
</html>