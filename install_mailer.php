<?php
// install_mailer.php
// Script otomatis download PHPMailer

$dir = __DIR__ . '/web_dashboard/PHPMailer';
if (!is_dir($dir)) mkdir($dir, 0777, true);

$files = [
    'PHPMailer.php' => 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/src/PHPMailer.php',
    'SMTP.php'      => 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/src/SMTP.php',
    'Exception.php' => 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/master/src/Exception.php'
];

echo "⬇️ Sedang mendownload PHPMailer...\n";

foreach ($files as $name => $url) {
    $content = file_get_contents($url);
    if ($content) {
        file_put_contents("$dir/$name", $content);
        echo "✅ Berhasil: $name\n";
    } else {
        echo "❌ Gagal: $name (Cek koneksi internet)\n";
    }
}
echo "🎉 Siap! Folder PHPMailer sudah dibuat di web_dashboard.\n";
?>