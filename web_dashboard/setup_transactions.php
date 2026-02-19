<?php
session_start();
require_once 'components/database.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. Cek Apakah Form Disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Ambil Data
    $method = $_POST['payment_method'] ?? 'bank';
    $file   = $_FILES['proof'];

    // 3. Validasi File Upload
    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
    $file_name   = $file['name'];
    $file_tmp    = $file['tmp_name'];
    $file_size   = $file['size'];
    $file_ext    = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Cek Ekstensi
    if (!in_array($file_ext, $allowed_ext)) {
        die("<script>alert('❌ Format file salah! Harap upload JPG atau PNG.'); window.history.back();</script>");
    }

    // Cek Ukuran (Maks 2MB)
    if ($file_size > 2 * 1024 * 1024) {
        die("<script>alert('❌ File terlalu besar! Maksimal 2MB.'); window.history.back();</script>");
    }

    // 4. Proses Simpan File
    // Buat nama file unik: proof_USERID_TIMESTAMP.jpg
    $new_name = "proof_" . $user_id . "_" . time() . "." . $file_ext;
    
    // Pastikan folder uploads ada
    $upload_dir = "uploads/proofs/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $destination = $upload_dir . $new_name;

    if (move_uploaded_file($file_tmp, $destination)) {
        
        // 5. Simpan ke Database
        try {
            // Cek dulu apakah user ini masih punya transaksi 'pending' sebelumnya?
            $check = $pdo->prepare("SELECT id FROM transactions WHERE user_id = ? AND status = 'pending'");
            $check->execute([$user_id]);
            
            if ($check->fetch()) {
                // Update transaksi lama yang masih pending
                $sql = "UPDATE transactions SET proof_file = ?, payment_method = ?, created_at = CURRENT_TIMESTAMP WHERE user_id = ? AND status = 'pending'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$new_name, $method, $user_id]);
            } else {
                // Buat transaksi baru
                $sql = "INSERT INTO transactions (user_id, payment_method, proof_file, status) VALUES (?, ?, ?, 'pending')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$user_id, $method, $new_name]);
            }

            // 6. Sukses -> Redirect ke Dashboard
            echo "<script>
                alert('✅ Bukti Pembayaran Berhasil Dikirim! Mohon tunggu verifikasi Admin.');
                window.location = 'easy.php';
            </script>";

        } catch (Exception $e) {
            echo "Database Error: " . $e->getMessage();
        }

    } else {
        echo "<script>alert('❌ Gagal mengupload gambar. Coba lagi.'); window.history.back();</script>";
    }
} else {
    header("Location: upgrade.php");
}
?>