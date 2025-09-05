<?php
require dirname(__DIR__).'/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

if (file_exists(dirname(__DIR__).'/.env.test')) {
    (new Dotenv())->load(dirname(__DIR__).'/.env.test');
}

// Base URL for requests
if (!defined('BASE_URL')) {
    define('BASE_URL', $_ENV['APP_BASE_URL'] ?? 'http://web:80');
}
