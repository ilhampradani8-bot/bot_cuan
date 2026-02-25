<?php
// FILE: web_dashboard/components/security.php

// --- Encryption Key Management ---
// Try to get the encryption key from a secure environment variable.
$key = getenv('ENCRYPTION_KEY');

// If not set, use a hardcoded fallback key for development.
// WARNING: For production, ALWAYS set the ENCRYPTION_KEY as an environment variable.
if (empty($key)) {
    $key = 'a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6e7f8a9b0c1d2e3f4a5b6c7d8e9f0a1b2';
}

// Define constants if they haven't been defined yet.
if (!defined('ENCRYPTION_KEY')) define('ENCRYPTION_KEY', $key);
if (!defined('CIPHER_METHOD')) define('CIPHER_METHOD', 'aes-256-cbc');


// --- Graceful Degradation for Encryption Functions ---
// Check if the OpenSSL extension is loaded. On Alpine, this often requires `apk add php-openssl`.
if (function_exists('openssl_encrypt')) {

    /**
     * Encrypts a string using OpenSSL.
     * @param string $data The string to encrypt.
     * @return string The encrypted string, base64 encoded with IV.
     */
    function encrypt_data($data) {
        $iv_length = openssl_cipher_iv_length(CIPHER_METHOD);
        $iv = openssl_random_pseudo_bytes($iv_length);
        $encrypted = openssl_encrypt($data, CIPHER_METHOD, ENCRYPTION_KEY, 0, $iv);
        // Combine IV with encrypted data for storage, then base64 encode.
        return base64_encode($iv . $encrypted);
    }

    /**
     * Decrypts a string using OpenSSL.
     * @param string $data The base64 encoded string (IV + data) to decrypt.
     * @return string|false The decrypted string, or false on failure.
     */
    function decrypt_data($data) {
        $decoded = base64_decode($data);
        $iv_length = openssl_cipher_iv_length(CIPHER_METHOD);
        $iv = substr($decoded, 0, $iv_length);
        $encrypted = substr($decoded, $iv_length);
        return openssl_decrypt($encrypted, CIPHER_METHOD, ENCRYPTION_KEY, 0, $iv);
    }

} else {
    // --- Fallback Functions if OpenSSL is NOT available ---
    // WARNING: These functions do NOT provide real encryption. This is a fallback
    // to prevent site crashes in development. For production, you MUST
    // install the PHP OpenSSL extension (`php-openssl`).

    /**
     * (Fallback) Returns data "as is" but base64 encoded to maintain format.
     */
    function encrypt_data($data) {
        // We encode it to prevent potential issues with binary data or special characters,
        // but this is NOT encryption.
        return base64_encode($data);
    }

    /**
     * (Fallback) Decodes base64 data, but does not perform decryption.
     */
    function decrypt_data($data) {
        return base64_decode($data);
    }
}

?>
