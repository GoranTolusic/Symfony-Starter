<?php

namespace App\Tests;

use Symfony\Component\Dotenv\Dotenv;

//Simple singleton class for loading .env.test and fast retrieving/modifying variables from it
class EnvConfig
{
    private static ?EnvConfig $instance = null;
    private string $file;
    public Dotenv $dotenv;
    private function __construct()
    {
        $this->dotenv = new Dotenv();
        $this->loadTestEnv();
    }

    private function loadTestEnv()
    {
        $projectRoot = dirname(__DIR__);
        $this->file = $projectRoot . '/.env.test';
        $this->dotenv->loadEnv($this->file);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(string $key, ?string $default = null): ?string
    {
        return $_ENV[$key] ?? $default;
    }

    public function append(string $varName, string $value): void
    {
        file_put_contents($this->file, "$varName=$value\n", FILE_APPEND);
    }
}
