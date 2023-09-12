<?php
// The data to be encrypted
$data = "This is a secret message";

// Generate a random initialization vector (IV)
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

// Encryption key (should be securely stored and managed)
$key = 'your-secret-key';

// Encrypt the data
$encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

// Store the IV along with the encrypted data
$encryptedMessage = base64_encode($iv . $encryptedData);

// Decrypt the data
$decodedMessage = base64_decode($encryptedMessage);
$ivSize = openssl_cipher_iv_length('aes-256-cbc');
$decryptedData = openssl_decrypt(substr($decodedMessage, $ivSize), 'aes-256-cbc', $key, 0, substr($decodedMessage, 0, $ivSize));

echo "Original data: $data\n";
echo "Encrypted message: $encryptedMessage\n";
echo "Decrypted data: $decryptedData\n";
