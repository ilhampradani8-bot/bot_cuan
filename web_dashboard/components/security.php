<?php
// components/security.php

// KUNCI RAHASIA (Simpan di server, jangan sampai bocor!)
// PASTE BLOK BARU INI
// Fetch the encryption key from an environment variable for maximum security.
$encryptionKey = getenv('ENCRYPTION_KEY');

// Check if the key is actually set in the environment.
if ($encryptionKey === false) {
    // If the key is not found, stop the application immediately.
    // This is a critical configuration error.
    die("Security Configuration Error: The ENCRYPTION_KEY is not defined.");
}

// Define the constant using the key fetched from the environment.
define('ENCRYPTION_KEY', $encryptionKey);


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