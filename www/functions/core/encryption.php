<?php
// usage
//$encrypted_data = $crypt->encrypt($data);
//$decrypted_data = $crypt->decrypt($encrypted_data);

function scrambleToken($str, $position, $numChars) {
  $str = str_replace("==", ".", $str);
  $str = str_replace("/", "%", $str);
  $str = str_replace("+", "$", $str);
  $str = str_replace("=", ":", $str);
  $randomChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  $randomCharString = implode("", array_map(function() use ($randomChars) {
    return $randomChars[random_int(0, strlen($randomChars) - 1)];
  }, range(1, $numChars)));
  $newStr = substr($str, 0, $position) . $randomCharString . substr($str, $position);
  return $newStr;
}

function unScrambleToken($str, $position, $numChars) {
  $newStr = substr_replace($str, "", $position, $numChars);
  $newStr = str_replace(":", "=", $newStr);
  $newStr = str_replace("$", "+", $newStr);
  $newStr = str_replace("%", "/", $newStr);
  $newStr = str_replace("==", ".", $newStr);
  return $newStr;
}

class EncryptData
{
  function encrypt($plaintext, $key)
  {
    $cipher = 'aes-256-gcm';
    $iv = openssl_random_pseudo_bytes(12);
    $tag = "";
    $ciphertext = openssl_encrypt($plaintext, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag, "", 16);
    $returnStr = base64_encode($iv . $tag . $ciphertext);
    $returnStr = scrambleToken($returnStr, 9, 17);
    return $returnStr;
  }

  function
  decrypt($ciphertext, $key)
  {
    $ciphertext = unScrambleToken($ciphertext, 9, 17);
    $cipher = 'aes-256-gcm';
    $ciphertext = base64_decode($ciphertext);
    $iv = substr($ciphertext, 0, 12);
    $tag = substr($ciphertext, 12, 16);
    $ciphertext = substr($ciphertext, 28);
    return openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag);
  }
}
