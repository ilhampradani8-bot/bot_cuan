<?php
// process.php - LOGIC PENYIMPANAN DATA (FINAL)
session_start();
require_once 'components/database.php';

// 1. CEK AKSES: Harus lewat Form POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// 2. AMBIL DATA UMUM
$mode = $_POST['mode'] ?? 'easy'; 
$wa   = $_POST['wa'] ?? '088971071139'; // Default nomor pemilik jika kosong

try {
    // =================================================================
    // LOGIKA MODE EASY (User Pemula)
    // =================================================================
    if ($mode === 'easy') {
        $coin  = $_POST['coin'];
        $price = $_POST['price'];

        // Simpan alert baru (Easy boleh punya banyak alert)
        $sql = "INSERT INTO alerts (phone_number, coin_pair, target_price, status, mode) 
                VALUES (:wa, :coin, :price, 'ACTIVE', 'easy')";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':wa' => $wa, ':coin' => $coin, ':price' => $price]);
    } 

    // =================================================================
    // LOGIKA MODE PRO (Cockpit Satu Layar)
    // =================================================================
    elseif ($mode === 'pro') {
        
        // LANGKAH 1: HAPUS SETTINGAN LAMA (PENTING!)
        // Supaya cuma ada 1 konfigurasi aktif di Cockpit Pro.
        // Kalau baris ini tidak ada, settingan akan menumpuk dan yang terbaca selalu yang lama.
        $pdo->exec("DELETE FROM alerts WHERE mode = 'pro'");

        // LANGKAH 2: SIAPKAN DATA BARU
        $cat      = $_POST['coin_cat'] ?? 'BIG';       // BIG, MICIN, TOP
        $strat    = $_POST['strategy_type'] ?? 'dynamic'; // dynamic / simple
        $pct      = $_POST['target_percent'] ?? 2.5;   // Angka persen
        $fund     = isset($_POST['fund_check']) ? 1 : 0; // Checkbox (1/0)
        
        // Array Indikator diubah jadi Teks JSON (misal: '["rsi","vol"]')
        $indicators = isset($_POST['indicators']) ? json_encode($_POST['indicators']) : '[]';

        // LANGKAH 3: SIMPAN DATA BARU
        // Kita isi target_price dengan 0 karena Pro pakai target_percent
        $sql = "INSERT INTO alerts (
                    phone_number, coin_pair, target_price, 
                    category, strategy, target_percent, indicators, fundamental_active, 
                    status, mode
                ) VALUES (
                    :wa, 'ALL_IN_CATEGORY', 0, 
                    :cat, :strat, :pct, :ind, :fund, 
                    'ACTIVE', 'pro'
                )";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':wa'    => $wa,
            ':cat'   => $cat,
            ':strat' => $strat,
            ':pct'   => $pct,
            ':ind'   => $indicators,
            ':fund'  => $fund
        ]);
    }

    // =================================================================
    // SELESAI: KEMBALI KE HALAMAN ASAL
    // =================================================================
    header("Location: " . ($mode === 'easy' ? 'easy.php' : 'pro.php'));
    exit;

} catch (Exception $e) {
    // Error Handler: Jika kolom database belum update
    die("❌ Gagal Menyimpan Data: " . $e->getMessage() . "<br>Saran: Coba jalankan upgrade_db.php lagi.");
}
?>