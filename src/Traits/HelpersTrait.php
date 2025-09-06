<?php

namespace App\Traits;

trait HelpersTrait
{
    function generateRandomString($length = 10) {
        $length = max(3, min(50, $length));
    
        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits = '0123456789';
        $all = $lower . $upper . $digits;
    
        $result = $lower[random_int(0, strlen($lower) - 1)];
        $result .= $upper[random_int(0, strlen($upper) - 1)];
        $result .= $digits[random_int(0, strlen($digits) - 1)];
    
        for ($i = 3; $i < $length; $i++) {
            $result .= $all[random_int(0, strlen($all) - 1)];
        }
    
        return str_shuffle($result);
    }
}
