<?php

namespace App\Tests\Controller\User;

use App\Tests\HttpTestCase;
use App\Tests\EnvConfig;

/**
 * @group user
 */
class FilterUserControllerTest extends HttpTestCase
{
    private EnvConfig $env;

    //HttpTestCase has final __constructor so we cant override it, but we can use setUp which is called before every test by defaul
    //We are using it to setup singleton env config so we can have quick access to some useful variables
    protected function setUp(): void
    {
        parent::setUp();
        $this->env = EnvConfig::getInstance();
    }

    public function testFilterUserValidRequest(): void
    {
        $headers = [
            'Authorization' => $this->env->get('TEST_TOKEN'),
            'Accept' => 'application/json'
        ];

        $payload = [
            "limit" => 10,
            "page" => 1,
            "term" => ""
        ];

        $response = $this->postJson('/user/filter', [
            'json' => $payload,
            'headers' => $headers
        ]);

        $this->assertContains(
            $response['status'],
            [200],
            "Expected status 200 (success), got {$response['status']}"
        );
    }

    public function testFilterUserBadRequest(): void
    {
        $headers = [
            'Authorization' => $this->env->get('TEST_TOKEN'),
            'Accept' => 'application/json'
        ];

        $payload = [
            "page" => 1,
            "term" => ""
        ];

        $response = $this->postJson('/user/filter', [
            'json' => $payload,
            'headers' => $headers
        ]);

        $this->assertContains(
            $response['status'],
            [400],
            "Expected status 200 (success), got {$response['status']}"
        );
    }

    public function testFilterUserUnauthorized(): void
    {
        $headers = [
            'Accept' => 'application/json'
        ];

        $payload = [
            "limit" => 10,
            "page" => 1,
            "term" => "something which does not exists in database"
        ];

        $response = $this->postJson('/user/filter', [
            'json' => $payload,
            'headers' => $headers
        ]);

        $this->assertContains(
            $response['status'],
            [401],
            "Expected status 200 (success), got {$response['status']}"
        );
    }

}
