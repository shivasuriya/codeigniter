<?php
        function oemr_password_hash($plaintext,$salt)
        {
            // if this is a SHA1 salt, the use prepended salt
            if(strpos($salt,'$SHA1$')===0)
            {
                return '$SHA1$' . sha1($salt.$plaintext);
            }
            else { // Otherwise use PHP crypt()
                $crypt_return = crypt($plaintext,$salt);
                if ( ($crypt_return == '*0') || ($crypt_return == '*1') || (strlen($crypt_return) < 6) ) {
                    // Error code returned by crypt or not hash, so die
                    error_log("FATAL ERROR: crypt() function is not working correctly in OpenEMR");
                    die("FATAL ERROR: crypt() function is not working correctly in OpenEMR");
                }
                else {
                    // Hash confirmed, so return the hash.
                    return $crypt_return;
                }
            }
        }
?>
