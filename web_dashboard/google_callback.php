<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// google_callback.php
session_start();
require_once 'components/database.php';
require_once 'config_google.php';

if (isset($_GET['code'])) {
    // 1. Tukar Kode dengan Token
    $token = getGoogleAccessToken($_GET['code']);

    if (isset($token['error'])) {
        die("Error Login Google: " . $token['error']);
    }

    // 2. Ambil Data User (Email, Nama, Foto)
    $google_user = getGoogleUserInfo($token['access_token']);
    
    $email = $google_user['email'];
    $name  = $google_user['name'];
    $gid   = $google_user['id'];
    $pic   = $google_user['picture'];

    // 3. Cek Database: Apakah user ini sudah ada?
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :e");
    $stmt->execute([':e' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // --- SUDAH ADA (LOGIN) ---
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['picture']  = $user['picture']; // Simpan foto di session
    } else {
        // --- BELUM ADA (SIGN UP OTOMATIS) ---
        // Buat username dari nama depan (hapus spasi)
        $username = strtolower(str_replace(' ', '', $name)) . rand(100,999);
        
        $sql = "INSERT INTO users (username, email, google_id, picture, password) 
                VALUES (:u, :e, :g, :p, 'google_login_no_pass')";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':u' => $username,
            ':e' => $email,
            ':g' => $gid,
            ':p' => $pic
        ]);
        
        // Langsung Login
        $_SESSION['user_id']  = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['picture']  = $pic;
    }

    // 4. Sukses -> Masuk Dashboard
    header("Location: easy.php");
    exit;
} else {
    // Kalau dibuka langsung tanpa kode, lempar ke login
    header("Location: login.php");
    exit;
}
?>