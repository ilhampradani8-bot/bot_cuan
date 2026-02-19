<?php
// proxy_market.php
// Tugas: Mengambil data dari Indodax lewat jalur server (Bypass CORS)

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Izinkan frontend manapun

// URL API Indodax
$url = 'https://indodax.com/api/tickers';

// Gunakan cURL agar terlihat seperti browser asli (Anti-Blokir)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Skip SSL check di local (Opsional)

$output = curl_exec($ch);

if(curl_errno($ch)){
    // Kalau gagal, kirim JSON error
    echo json_encode(['error' => curl_error($ch)]);
} else {
    // Kalau sukses, kirim mentahan data dari Indodax
    echo $output;
}

curl_close($ch);
?>