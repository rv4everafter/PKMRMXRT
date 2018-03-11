<?php

namespace App\Helpers\General;

/**
 * Class HtmlHelper.
 */
class ReferralCode
{
    static public function generate($options = []) {
        $length         = (isset($options['length']) ? filter_var($options['length'], FILTER_VALIDATE_INT) : 8 );
        $prefix         = (isset($options['prefix']) ? self::cleanString(filter_var($options['prefix'], FILTER_SANITIZE_STRING)) : '' );
        $suffix         = (isset($options['suffix']) ? self::cleanString(filter_var($options['suffix'], FILTER_SANITIZE_STRING)) : '' );
        $useLetters     = (isset($options['letters']) ? filter_var($options['letters'], FILTER_VALIDATE_BOOLEAN) : true );
        $useNumbers     = (isset($options['numbers']) ? filter_var($options['numbers'], FILTER_VALIDATE_BOOLEAN) : false );
        $useSymbols     = (isset($options['symbols']) ? filter_var($options['symbols'], FILTER_VALIDATE_BOOLEAN) : false );
        $useMixedCase   = (isset($options['mixed_case']) ? filter_var($options['mixed_case'], FILTER_VALIDATE_BOOLEAN) : false );
        $mask           = (isset($options['mask']) ? filter_var($options['mask'], FILTER_SANITIZE_STRING) : false );
        $uppercase    = ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'];
        $lowercase    = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm'];
        $numbers      = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $symbols      = ['`', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_', '=', '+', '\\', '|', '/', '[', ']', '{', '}', '"', "'", ';', ':', '<', '>', ',', '.', '?'];
        $characters   = [];
        $coupon = '';
        if ($useLetters) {
            if ($useMixedCase) {
                $characters = array_merge($characters, $lowercase, $uppercase);
            } else {
                $characters = array_merge($characters, $uppercase);
            }
        }
        if ($useNumbers) {
            $characters = array_merge($characters, $numbers);
        }
        if ($useSymbols) {
            $characters = array_merge($characters, $symbols);
        }
        if ($mask) {
            for ($i = 0; $i < strlen($mask); $i++) {
                if ($mask[$i] === 'X') {
                    $coupon .= $characters[mt_rand(0, count($characters) - 1)];
                } else {
                    $coupon .= $mask[$i];
                }
            }
        } else {
            for ($i = 0; $i < $length; $i++) {
                $coupon .= $characters[mt_rand(0, count($characters) - 1)];
            }
        }
        return $prefix . $coupon . $suffix;
    }
}
