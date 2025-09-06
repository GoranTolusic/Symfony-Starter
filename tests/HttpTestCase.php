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
        $response = $this->client->request($method, $url, $options);
        try {
            $content = json_decode($response->getContent(), true);
            $status = $response->getStatusCode();
        } catch (\Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface $e) {
            $status = $e->getResponse()->getStatusCode();
            $content = json_decode($e->getResponse()->getContent(false), true);
        }

        return [
            'status' => $status,
            'body' => $content
        ];
    }

    protected function getJson(string $url, array $options = []): array
    {
        return $this->request('GET', $url, $options);
    }

    protected function postJson(string $url, array $options = []): array
    {
        return $this->request('POST', $url, $options);
    }

    protected function putJson(string $url, array $options = []): array
    {
        return $this->request('', $url, $options);
    }
}
