<?php
// File: components/encryption.php
// Objective: Provides strong, reusable encryption functions for sensitive data.

// IMPORTANT: This key MUST be kept secret and should ideally be loaded from a
// secure, non-public environment file (.env) in a real production scenario.
// For this project, we define it here, but ensure it's a long, random string.
define('ENCRYPTION_KEY', 'def000006c642732938f20358899885140b904f466487121b65e525167576a0d4c81a29c153835f839f993f30997f742337ad75122e269781b1d75f2849504e9');
define('ENCRYPTION_METHOD', 'aes-256-cbc');

/**
 * Encrypts data using AES-256-CBC.
 * @param string $data The plaintext data to encrypt.
 * @param string $key The encryption key.
 * @return string The base64-encoded encrypted data, including the IV.
 */
function encrypt_data($data, $key) {
    $iv_length = openssl_cipher_iv_length(ENCRYPTION_METHOD);
    $iv = openssl_random_pseudo_bytes($iv_length);
    
    $encrypted = openssl_encrypt($data, ENCRYPTION_METHOD, $key, OPENSSL_RAW_DATA, $iv);
    
    // Prepend the IV to the encrypted data for use during decryption.
    return base64_encode($iv . $encrypted);
}

/**
 * Decrypts data encrypted with encrypt_data().
 * @param string $data The base64-encoded data (IV + ciphertext).
 * @param string $key The encryption key.
 * @return string|false The decrypted plaintext, or false on failure.
 */
function decrypt_data($data, $key) {
    $data = base64_decode($data);
    $iv_length = openssl_cipher_iv_length(ENCRYPTION_METHOD);
    $iv = substr($data, 0, $iv_length);
    $encrypted = substr($data, $iv_length);
    
    return openssl_decrypt($encrypted, ENCRYPTION_METHOD, $key, OPENSSL_RAW_DATA, $iv);
}
?>
