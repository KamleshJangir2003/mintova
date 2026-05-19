<?php
function tron_base58_to_hex($address) {
    $alphabet = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
    $base = strlen($alphabet);
    $bytes = [0];
    for($i = 0; $i < strlen($address); $i++) {
        $char = strpos($alphabet, $address[$i]);
        $carry = $char;
        for($j = count($bytes)-1; $j >= 0; $j--) {
            $carry += $base * $bytes[$j];
            $bytes[$j] = $carry % 256;
            $carry = intdiv($carry, 256);
        }
        while($carry > 0) {
            array_unshift($bytes, $carry % 256);
            $carry = intdiv($carry, 256);
        }
    }
    // Remove checksum (last 4 bytes)
    $bytes = array_slice($bytes, 0, count($bytes) - 4);
    $hex = '';
    foreach($bytes as $b) $hex .= str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
    return $hex;
}

$wallet = 'TTuY7SFTr1c3VxUH43GcQSQEW5Tf62cdYU';
$hex = tron_base58_to_hex($wallet);
echo "Wallet:     $wallet\n";
echo "Hex result: $hex\n";
echo "TX to hex:  41c4c08d6d00829b1a5aa9d7895a32c667984cca4b\n";
echo "Match: " . (strtolower($hex) === '41c4c08d6d00829b1a5aa9d7895a32c667984cca4b' ? "YES ✅" : "NO ❌") . "\n";
