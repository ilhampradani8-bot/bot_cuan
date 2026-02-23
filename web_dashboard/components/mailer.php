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
// PASTE BLOK BARU INI
function sendMail($to, $subject, $messageHTML) {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // --- 1. SERVER CONFIGURATION (Now using Environment Variables) ---
        $mail->SMTPDebug = 0;                                       // Disable verbose debug output for production
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Specify main SMTP server (Gmail)
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication

        // Fetch credentials from environment variables for security
        $smtpUser = getenv('SMTP_USER');
        $smtpPass = getenv('SMTP_PASS');

        // Stop if credentials are not set
        if (!$smtpUser || !$smtpPass) {
            // Do not expose detailed errors to the user in production
            error_log("Mailer Error: SMTP credentials are not configured.");
            return false;
        }

        $mail->Username   = $smtpUser;                              // SMTP username
        $mail->Password   = $smtpPass;                              // SMTP password (use App Password for Gmail)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable TLS encryption
        $mail->Port       = 587;                                    // TCP port for TLS

        // --- 2. SENDER & RECIPIENT ---
        $mail->setFrom('no-reply@tradingsafe.com', 'TradingSafe System'); // Set the 'From' address
        $mail->addAddress($to);                                     // Add a recipient

        // --- 3. EMAIL CONTENT (Dynamic) ---
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = $subject;                                  // The subject of the email
        
        // A clean HTML template for the email body
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ddd; border-radius: 8px; max-width: 400px; background-color: #ffffff;'>
                <h2 style='color: #1e3a8a; text-align: center; border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;'>TradingSafe System</h2>
                <div style='padding: 10px 0; color: #333; line-height: 1.6;'>
                    $messageHTML
                </div>
                <p style='font-size: 11px; color: #999; margin-top: 20px; text-align: center; border-top: 1px solid #eee; padding-top: 10px;'>
                    This is an automated email from the TradingSafe system.
                </p>
            </div>";
        
        // Plain text version for non-HTML mail clients
        $mail->AltBody = strip_tags($messageHTML);

        $mail->send();
        return true; // Return true on success
    } catch (Exception $e) {
        // Log the detailed error on the server, don't show it to the user
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false; // Return false on failure
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