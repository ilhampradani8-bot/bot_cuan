<?php
// web_dashboard/login.php
session_start();
require_once 'components/database.php';

// Cek Config Google
$google_active = false;
if (file_exists('components/config_google.php')) {
    require_once 'components/config_google.php';
    if (defined('GOOGLE_CLIENT_ID') && GOOGLE_CLIENT_ID != '') {
        $google_active = true;
    }
}

// =======================================================================
// 1. LOGIKA PENERIMA TAMU GOOGLE (TARUH PALING ATAS!)
// =======================================================================
if (isset($_GET['code'])) {
    if (!$google_active) { die("Google Config Missing!"); }
    
    // A. Tukar "Kode" jadi "Tiket Masuk" (Access Token)
    $token_url = 'https://oauth2.googleapis.com/token';
    $post_data = [
        'code'          => $_GET['code'],
        'client_id'     => GOOGLE_CLIENT_ID,
        'client_secret' => GOOGLE_CLIENT_SECRET,
        'redirect_uri'  => GOOGLE_REDIRECT_URL,
        'grant_type'    => 'authorization_code'
    ];
    
    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Penting buat Localhost
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if (isset($response['access_token'])) {
        // B. Ambil Data Profil User dari Google
        $info_url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $response['access_token'];
        $ch = curl_init($info_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $google_user = json_decode(curl_exec($ch), true);
        curl_close($ch);

        $g_email = $google_user['email'];
        $g_name  = $google_user['name'];
        $g_id    = $google_user['id'];

        // C. Cek apakah user ini sudah ada di Database?
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$g_email]);
        $user = $stmt->fetch();

        if ($user) {
            // ---> KASUS 1: USER LAMA (LOGIN)
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_verified'] = $user['is_verified'];
        } else {
            // ---> KASUS 2: USER BARU (REGISTER OTOMATIS)
            // Buat username dari nama google (hapus spasi)
            $username = str_replace(' ', '', strtolower($g_name)) . rand(10,99);
            // Password dummy (karena dia login pake google)
            $dummy_pass = password_hash(uniqid(), PASSWORD_DEFAULT); 
            
            $sql = "INSERT INTO users (username, email, password, google_id, is_verified, full_name) VALUES (?, ?, ?, ?, 1, ?)";
            $stmtInsert = $pdo->prepare($sql);
            $stmtInsert->execute([$username, $g_email, $dummy_pass, $g_id, $g_name]);
            
            // Langsung set session
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $g_email;
            $_SESSION['is_verified'] = 1; // User Google otomatis Verified
        }

        // D. TENDANG KE DASHBOARD (INI KUNCINYA!)
        header("Location: easy.php");
        exit; // Stop script di sini biar gak muat halaman login lagi
    }
}

// =======================================================================
// 2. LOGIKA LOGIN MANUAL (USER BIASA)
// =======================================================================
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_input = trim($_POST['username']);
    $pass_input = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u OR email = :u");
    $stmt->execute([':u' => $user_input]);
    $data = $stmt->fetch();

    if ($data && password_verify($pass_input, $data['password'])) {
        $_SESSION['user_id']  = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['email']    = $data['email'];
        $_SESSION['is_verified'] = $data['is_verified']; 
        header("Location: easy.php");
        exit;
    } else {
        $error = "Username atau Password salah.";
    }
}

// --- GENERATE URL LOGIN GOOGLE ---
$google_login_url = "#";
if ($google_active) {
    $google_login_url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
        'client_id'     => GOOGLE_CLIENT_ID,
        'redirect_uri'  => GOOGLE_REDIRECT_URL,
        'response_type' => 'code',
        'scope'         => 'email profile',
        'access_type'   => 'online'
    ]);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - TradingSafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 rounded-2xl shadow-xl border border-slate-100 w-full max-w-sm">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-blue-900 tracking-tight">Trading<span class="text-blue-600">Safe</span></h1>
            <p class="text-xs text-slate-400 mt-2">Masuk untuk melanjutkan aktivitas trading.</p>
        </div>

        <?php if($error): ?>
            <div class="bg-red-50 text-red-600 text-xs p-3 rounded-lg mb-6 text-center font-bold"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email / Username</label>
                <input type="text" name="username" class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:border-blue-500 outline-none transition bg-slate-50 focus:bg-white" required>
            </div>
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="block text-xs font-bold text-slate-500 uppercase">Password</label>
                    <a href="forgot.php" class="text-[10px] text-blue-600 font-bold hover:underline">Lupa Password?</a>
                </div>
                <input type="password" name="password" class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:border-blue-500 outline-none transition bg-slate-50 focus:bg-white" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3.5 rounded-xl font-bold text-sm hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                Masuk Dashboard
            </button>
        </form>

        <div class="relative my-8 text-center">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
            <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-2 text-slate-400 font-bold tracking-widest">Atau</span></div>
        </div>

        <?php if ($google_active): ?>
            <a href="<?= $google_login_url ?>" class="flex items-center justify-center gap-3 w-full border border-slate-200 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition">
                <img src="https://www.svgrepo.com/show/355037/google.svg" class="w-5 h-5">
                Masuk dengan Google
            </a>
        <?php else: ?>
            <button onclick="alert('Client ID Kosong atau File Config Hilang')" class="flex items-center justify-center gap-3 w-full border border-red-200 bg-red-50 py-3 rounded-xl text-sm font-bold text-red-600">
                Google Error
            </button>
        <?php endif; ?>

        <p class="text-center text-xs text-slate-400 mt-8">
            Belum punya akun? <a href="register.php" class="text-blue-600 font-bold hover:underline">Daftar Sekarang</a>
        </p>
    </div>
</body>
</html>