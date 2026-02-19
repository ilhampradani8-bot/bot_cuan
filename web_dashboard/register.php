<?php
session_start();
require_once 'components/database.php';
require_once 'components/mailer.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Cek User Kembar
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    
    if ($stmt->fetch()) {
        $error = "Username atau Email sudah terdaftar!";
    } else {
        // 2. Hash Password & Buat Token
        $passHash = password_hash($password, PASSWORD_DEFAULT);
        $token    = rand(100000, 999999);

        // 3. Simpan ke Database (is_verified = 0)
        $sql = "INSERT INTO users (username, email, password, verify_token, is_verified) VALUES (?, ?, ?, ?, 0)";
        $stmtInsert = $pdo->prepare($sql);
        
        if ($stmtInsert->execute([$username, $email, $passHash, $token])) {
            
            // 4. Kirim Email (Pakai fungsi baru sendMail)
            $subject = "Selamat Datang di TradingSafe";
            $msgHTML = "Halo <b>$username</b>,<br>Akun berhasil dibuat.<br>Kode verifikasi Anda: <b>$token</b>";
            
            sendMail($email, $subject, $msgHTML);

            // 5. Auto Redirect ke Login
            echo "<script>
                alert('✅ Pendaftaran Berhasil! Silakan Login.');
                window.location = 'login.php';
            </script>";
            exit;
        } else {
            $error = "Gagal mendaftar. Coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm border border-slate-100">
        <h2 class="text-2xl font-bold text-center text-slate-800 mb-6">Buat Akun Baru</h2>
        
        <?php if($error): ?>
            <div class="bg-red-50 text-red-600 text-xs p-3 rounded-lg mb-4 text-center font-bold">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Username</label>
                <input type="text" name="username" class="w-full border border-slate-200 rounded-xl p-3 outline-none focus:border-blue-500 transition" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-slate-200 rounded-xl p-3 outline-none focus:border-blue-500 transition" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password</label>
                <input type="password" name="password" class="w-full border border-slate-200 rounded-xl p-3 outline-none focus:border-blue-500 transition" required>
            </div>
            
            <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-xl font-bold hover:bg-slate-800 transition shadow-lg">
                DAFTAR SEKARANG
            </button>
        </form>

        <p class="text-center text-xs text-slate-400 mt-6">
            Sudah punya akun? <a href="login.php" class="text-blue-600 font-bold hover:underline">Login</a>
        </p>
    </div>

</body>
</html>