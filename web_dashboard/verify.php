<?php
// web_dashboard/verify.php
session_start();
require_once 'components/database.php';
require_once 'components/mailer.php'; 

// Proteksi: Hanya user login yang boleh masuk sini
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";
$messageType = ""; // success atau error

// --- LOGIKA KIRIM ULANG KODE ---
if (isset($_GET['resend'])) {
    // Ambil email user yang sedang login
    $stmt = $pdo->prepare("SELECT email, username FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($user && !empty($user['email'])) {
        $code = rand(100000, 999999);
        // Update kode milik user INI SAJA
        $stmtUpdate = $pdo->prepare("UPDATE users SET verify_token = ? WHERE id = ?");
        $stmtUpdate->execute([$code, $user_id]);

        // Kirim Email
        $subject = "Kode Verifikasi TradingSafe";
        $body = "Halo <b>{$user['username']}</b>,<br>Kode verifikasi Anda adalah: <b>$code</b>";
        
        if (sendMail($user['email'], $subject, $body)) {
            $message = "Kode baru telah dikirim ke email: " . htmlspecialchars($user['email']);
            $messageType = "success";
        } else {
            $message = "Gagal mengirim email. Pastikan konfigurasi SMTP benar.";
            $messageType = "error";
        }
    } else {
        $message = "User ini tidak memiliki email yang valid. Silakan update di Pengaturan.";
        $messageType = "error";
    }
}

// --- LOGIKA VERIFIKASI KODE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code_input = trim($_POST['code']);

    // LOGIKA KETAT: Cek kode HANYA pada row milik user_id saat ini
    // Jangan pernah SELECT * FROM users WHERE code = $code (INI BAHAYA!)
    $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ? AND verify_token = ?");
    $stmt->execute([$user_id, $code_input]);
    $check = $stmt->fetch();

    if ($check) {
        // KODE BENAR & COCOK DENGAN USER ID
        $update = $pdo->prepare("UPDATE users SET is_verified = 1, verify_token = NULL WHERE id = ?");
        $update->execute([$user_id]);

        // Update session biar tidak perlu logout
        $_SESSION['is_verified'] = 1;

        echo "<script>alert('✅ Verifikasi Berhasil!'); window.location='easy.php';</script>";
        exit;
    } else {
        $message = "Kode salah atau tidak valid.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full border border-slate-100">
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Verifikasi Email</h2>
            <p class="text-xs text-slate-400 mt-1">Masukkan kode 6 digit yang dikirim ke email Anda.</p>
        </div>

        <?php if($message): ?>
            <div class="p-3 rounded-lg text-xs font-bold mb-4 text-center <?= $messageType == 'success' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="text" name="code" placeholder="Contoh: 123456" class="w-full text-center text-2xl tracking-widest border border-slate-200 rounded-xl p-3 focus:border-blue-500 outline-none transition" maxlength="6" required>
            
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                VERIFIKASI
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="?resend=1" class="text-xs text-blue-600 font-bold hover:underline">Kirim Ulang Kode</a>
            <div class="mt-4">
                <a href="logout.php" class="text-[10px] text-slate-400 hover:text-red-500">Keluar / Ganti Akun</a>
            </div>
        </div>
    </div>

</body>
</html>