<?php
// config_google.php

// GANTI DENGAN KUNCI DARI GOOGLE CLOUD CONSOLE
define('GOOGLE_CLIENT_ID', '204633035549-9v5nia5dd6bke6lrtl5nuhtehl0felao.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');

// URL redirect harus SAMA PERSIS dengan yang didaftarkan di Google Console
define('GOOGLE_REDIRECT_URL', 'http://localhost:8000/web_dashboard/login.php');

// Fungsi Helper untuk Request ke Google
function getGoogleAccessToken($code) {
    $url = 'https://oauth2.googleapis.com/token';
    $params = [
        'code' => $code,
        'client_id' => GOOGLE_CLIENT_ID,
        'client_secret' => GOOGLE_CLIENT_SECRET,
        'redirect_uri' => GOOGLE_REDIRECT_URL,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // TAMBAHAN: Bypass SSL Check (Khusus Localhost/Alpine)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        die('Curl Error: ' . curl_error($ch));
    }
    
    curl_close($ch);
    
    return json_decode($response, true);
}

function getGoogleUserInfo($access_token) {
    $url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $access_token;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}
?>