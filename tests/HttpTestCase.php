<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;

class HttpTestCase extends TestCase
{
    protected HttpClientInterface $client;

    protected function setUp(): void
    {
        $this->client = HttpClient::create([
            'base_uri' => BASE_URL,
            'timeout' => 10.0,
        ]);
    }

    protected function request(string $method, string $url, array $options = [])
    {
        return $this->client->request($method, $url, $options);
    }

    protected function getJson(string $url, array $options = []): array
    {
        $response = $this->request('GET', $url, $options);
        return json_decode($response->getContent(), true);
    }

    protected function postJson(string $url, array $data = []): array
    {
        $response = $this->request('POST', $url, [
            'json' => $data,
        ]);
        return json_decode($response->getContent(), true);
    }
}
