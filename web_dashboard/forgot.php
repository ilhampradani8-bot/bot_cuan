<?php
session_start();
require_once 'components/database.php';
require_once 'components/mailer.php';

$msg = "";
$msgType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // 1. Cek apakah email terdaftar?
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // 2. Generate Kode Unik 6 Digit
        $code = rand(100000, 999999);

        // 3. Simpan Kode ke Database (Pakai kolom verify_token lagi biar hemat)
        $update = $pdo->prepare("UPDATE users SET verify_token = ? WHERE id = ?");
        $update->execute([$code, $user['id']]);

        // 4. Kirim Email
        $subject = "Reset Password - TradingSafe";
        $body = "Halo <b>{$user['username']}</b>,<br><br>Permintaan reset password diterima.<br>Kode Reset Anda: <h2 style='color:blue'>$code</h2><br>Jangan berikan kode ini ke siapa pun.";

        if (sendMail($email, $subject, $body)) {
            // Simpan email di session biar gak perlu ketik ulang di halaman sebelah
            $_SESSION['reset_email'] = $email;
            header("Location: reset_password.php");
            exit;
        } else {
            $msg = "Gagal mengirim email. Coba lagi nanti.";
            $msgType = "error";
        }
    } else {
        // Demi keamanan, jangan kasih tau kalau email gak ada. Bilang saja "Jika email terdaftar..."
        $msg = "Jika email terdaftar, kode akan dikirim.";
        $msgType = "success"; 
        // Tapi buat testing Mas sendiri, boleh ganti jadi "Email tidak ditemukan".
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full border border-slate-100">
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Reset Password</h2>
            <p class="text-xs text-slate-400 mt-1">Masukkan email akun Anda yang terdaftar.</p>
        </div>

        <?php if($msg): ?>
            <div class="p-3 rounded-lg text-xs font-bold mb-4 text-center <?= $msgType == 'success' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' ?>">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:border-blue-500 outline-none transition" required>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                KIRIM KODE
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="login.php" class="text-xs text-slate-400 hover:text-blue-600 font-bold">Kembali ke Login</a>
        </div>
    </div>

</body>
</html>