<?php

namespace App\Tests\Controller\Auth;

use App\Tests\HttpTestCase;
use App\Tests\EnvConfig;

/**
 * @group user
 */
class GetUserControllerTest extends HttpTestCase
{
    private EnvConfig $env;

    //HttpTestCase has final __constructor so we cant override it, but we can use setUp which is called before every test by defaul
    //We are using it to setup singleton env config so we can have quick access to some useful variables
    protected function setUp(): void
    {
        parent::setUp();
        $this->env = EnvConfig::getInstance();
    }

    public function testGetUserValidRequest(): void
    {
        $params = ["showTags" => 'true']; //We can comment this line
        $headers = [
            'Authorization' => $this->env->get('TEST_TOKEN'),
            'Accept' => 'application/json'
        ];

        $response = $this->getJson('/user/' . $this->env->get('TEST_ID'), [
            'query' => $params,
            'headers' => $headers
        ]);

        $this->assertContains(
            $response['status'],
            [200],
            "Expected status 200 (success), got {$response['status']}"
        );
    }

    public function testGetUserUnauthorized(): void
    {
        $params = ["showTags" => 'true']; //We can comment this line
        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->getJson('/user/' . $this->env->get('TEST_ID'), [
            'query' => $params,
            'headers' => $headers
        ]);

        $this->assertContains(
            $response['status'],
            [401],
            "Expected status 200 (success), got {$response['status']}"
        );
    }

    public function testGetUserNotFound(): void
    {
        $params = ["showTags" => 'true']; //We can comment this line
        $headers = [
            'Authorization' => $this->env->get('TEST_TOKEN'),
            'Accept' => 'application/json'
        ];

        $response = $this->getJson('/user/0', [
            'query' => $params,
            'headers' => $headers
        ]);

        $this->assertContains(
            $response['status'],
            [404],
            "Expected status 200 (success), got {$response['status']}"
        );
    }
}
