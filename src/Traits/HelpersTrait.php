<?php

namespace App\Traits;

trait HelpersTrait
{
    function generateRandomString($length = 10)
    {
        $length = max(3, min(50, $length));
        $lower  = 'abcdefghijklmnopqrstuvwxyzšđčćž';
        $upper  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZŠĐČĆŽ';
        $digits = '0123456789';
        $all    = $lower . $upper . $digits;

        $pick = function ($string) {
            $len = mb_strlen($string, 'UTF-8');
            return mb_substr($string, random_int(0, $len - 1), 1, 'UTF-8');
        };

        $result = [];
        $result[] = $pick($lower);
        $result[] = $pick($upper);
        $result[] = $pick($digits);

        for ($i = 3; $i < $length; $i++) {
            $result[] = $pick($all);
        }

        shuffle($result);
        return implode('', $result);
    }
}
