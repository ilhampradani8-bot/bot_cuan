<?php
// components/security.php

// KUNCI RAHASIA (Simpan di server, jangan sampai bocor!)
define('ENCRYPTION_KEY', 'KunciRahasiaSuperSulit123!@#'); 

function encryptAPI($data) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', ENCRYPTION_KEY, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decryptAPI($data) {
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', ENCRYPTION_KEY, 0, $iv);
}
?>