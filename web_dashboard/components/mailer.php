<?php
// web_dashboard/components/mailer.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Pastikan path folder PHPMailer ini sudah benar sesuai struktur Mas
require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';

// KITA UBAH NAMA FUNGSI JADI: sendMail
// Parameter dibuat dinamis: $to, $subject, $message
function sendMail($to, $subject, $messageHTML) {
    $mail = new PHPMailer(true);
    try {
        // --- 1. CONFIG SERVER (SAMA SEPERTI YANG MAS PUNYA) ---
        $mail->SMTPDebug = 0; 
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        // GANTI DENGAN EMAIL & APP PASSWORD MAS
        $mail->Username   = 'hacker.ai.prof@gmail.com'; 
        $mail->Password   = 'jjmmjehotkardvwh'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Bypass SSL (Penting untuk Linux Alpine/Localhost)
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // --- 2. PENGIRIM & PENERIMA ---
        $mail->setFrom('no-reply@sniperbot.com', 'Sniper Bot Admin');
        $mail->addAddress($to);

        // --- 3. KONTEN EMAIL (DINAMIS) ---
        $mail->isHTML(true);
        $mail->Subject = $subject;
        
        // Kita bungkus pesan dalam Template HTML yang rapi
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ddd; border-radius: 8px; max-width: 400px; background-color: #ffffff;'>
                <h2 style='color: #1e3a8a; text-align: center; border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;'>TradingSafe System</h2>
                <div style='padding: 10px 0; color: #333; line-height: 1.6;'>
                    $messageHTML
                </div>
                <p style='font-size: 11px; color: #999; margin-top: 20px; text-align: center; border-top: 1px solid #eee; padding-top: 10px;'>
                    Email ini dikirim otomatis oleh sistem TradingSafe.
                </p>
            </div>";
        
        // Versi text polos buat jaga-jaga
        $mail->AltBody = strip_tags($messageHTML);

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Mas bisa uncomment baris bawah ini kalau mau lihat detail errornya di layar
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

function sendVerificationEmail($to, $code) {
    $subject = "Verifikasi Akun TradingSafe";
    $message = "
        <h3>Selamat Datang!</h3>
        <p>Terima kasih telah mendaftar. Kode verifikasi Anda adalah:</p>
        <h1 style='color:blue'>$code</h1>
        <p>Silakan masukkan kode ini di halaman verifikasi.</p>
    ";
    // Panggil fungsi utama kita
    return sendMail($to, $subject, $message);
}
?>

?>