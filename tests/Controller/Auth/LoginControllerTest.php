<?php

namespace App\Tests\Controller\Auth;

use App\Tests\HttpTestCase;
use App\Tests\EnvConfig;

/**
 * @group auth
 */
class LoginControllerTest extends HttpTestCase
{
    private EnvConfig $env;

    //HttpTestCase has final __constructor so we cant override it, but we can use setUp which is called before every test by defaul
    //We are using it to setup singleton env config so we can have quick access to some useful variables
    protected function setUp(): void
    {
        parent::setUp();
        $this->env = EnvConfig::getInstance();
    }

    public function testLoginWithValidPayload(): void
    {
        $payload = [
            "email" => $this->env->get('TEST_EMAIL'),
            "password" => $this->env->get('TEST_PASSWORD'),
        ];

        

        $response = $this->postJson('/auth/login', $payload);
        $this->assertContains(
            $response['status'],
            [200],
            "Expected status 200 (success), got {$response['status']}"
        );

        echo 'token iz responsa';
        var_dump($response['body']['data']);
        $this->env->append('AUTH_TOKEN', $response['body']['data']);
        echo 'token spremljen u env';
        var_dump($this->env->get('AUTH_TOKEN'));
    }

    public function testLoginWithInvalidPayload(): void
    {
        $payload = [
            'email' => 'not-an-email',
            'password' => ''
        ];

        $response = $this->postJson('/auth/login', $payload);
        $this->assertContains(
            $response['status'],
            [400],
            "Expected status 400 (Bad Request), got {$response['status']}"
        );
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $payload = [
            'email' => $this->env->get('TEST_EMAIL'),
            'password' => 'invalid123Password'
        ];

        $response = $this->postJson('/auth/login', $payload);
        $this->assertContains(
            $response['status'],
            [401],
            "Expected status 401 (Unauthorized), got {$response['status']}"
        );
    }
}
