<?php
class Chiffrement {
   /* private static $cipher  = MCRYPT_RIJNDAEL_128;          // Algorithme utilis� pour le cryptage des blocs
    private static $key     = '7IU8GVrTxHDh72EA12ZkJw';    // Cl� de cryptage
    private static $mode    = 'cbc';                        // Mode op�ratoire (traitement des blocs)
 
    public static function crypt($data){
        $keyHash = md5(self::$key);
        $key = substr($keyHash, 0,   mcrypt_get_key_size(self::$cipher, self::$mode) );
        $iv  = substr($keyHash, 0, mcrypt_get_block_size(self::$cipher, self::$mode) );
 
        $data = mcrypt_encrypt(self::$cipher, $key, $data, self::$mode, $iv);
        return base64_encode($data);
    }
 
    public static function decrypt($data){
        $keyHash = md5(self::$key);
        $key = substr($keyHash, 0,   mcrypt_get_key_size(self::$cipher, self::$mode) );
        $iv  = substr($keyHash, 0, mcrypt_get_block_size(self::$cipher, self::$mode) );
 
        $data = base64_decode($data);
        $data = mcrypt_decrypt(self::$cipher, $key, $data, self::$mode, $iv);
        return rtrim($data);
    }*/

  
    public static function encrypt_decrypt($action, $string)
    {
        /* =================================================
         * ENCRYPTION-DECRYPTION
         * =================================================
         * ENCRYPTION: encrypt_decrypt('encrypt', $string);
         * DECRYPTION: encrypt_decrypt('decrypt', $string) ;
         */
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'WS-SERVICE-KEY';
        $secret_iv = 'WS-SERVICE-VALUE';
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ($action == 'encrypt') {
            $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        } else {
            if ($action == 'decrypt') {
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
            }
        }
        return $output;
    }


}
?>