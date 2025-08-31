<?php

//this will output log directly into server console
if (!function_exists('consoleLog')) {
    function consoleLog($data): void
    {
        error_log("\033[31m" . print_r($data, true) . "\033[0m");
    }
}