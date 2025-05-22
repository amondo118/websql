<?php
function decode_password($filename) {
    $key = [5, -14, 31, -9, 3];
    $decoded = [];

    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        $decoded_line = '';
        $key_index = 0;

        for ($i = 0; $i < strlen($line); $i++) {
            $char = $line[$i];
            $ascii = ord($char);
            $new_char = chr($ascii - $key[$key_index]);
            $decoded_line .= $new_char;

            $key_index = ($key_index + 1) % count($key);
        }
        if (strpos($decoded_line, '*') !== false) {
            [$username, $password] = explode('*', $decoded_line);
            $decoded[$username] = $password;
        }
    }

    return $decoded;
}
?>
