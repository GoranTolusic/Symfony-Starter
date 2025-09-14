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
        $content = file($this->file, FILE_IGNORE_NEW_LINES);
        $found = false;
        foreach ($content as &$line) {
            if (str_starts_with($line, "$varName=")) {
                $line = "$varName=$value";
                $found = true;
                break;
            }
        }
        if (!$found) {
            $content[] = "$varName=$value";
        }
        file_put_contents($this->file, implode("\n", $content) . "\n");
        $this->dotenv->loadEnv($this->file);
    }
}
