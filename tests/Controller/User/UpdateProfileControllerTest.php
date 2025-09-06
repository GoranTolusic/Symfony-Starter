<?php

namespace App\Tests\Controller\User;

use App\Tests\HttpTestCase;
use App\Tests\EnvConfig;
use App\Traits\HelpersTrait;

/**
 * @group user
 */
class UpdateProfileControllerTest extends HttpTestCase
{
    use HelpersTrait;
    private EnvConfig $env;

    //HttpTestCase has final __constructor so we cant override it, but we can use setUp which is called before every test by defaul
    //We are using it to setup singleton env config so we can have quick access to some useful variables
    protected function setUp(): void
    {
        parent::setUp();
        $this->env = EnvConfig::getInstance();
    }

    public function testUpdateProfileValidRequest(): void
    {
        $headers = [
            'Authorization' => $this->env->get('TEST_TOKEN'),
            'Accept' => 'application/json'
        ];

        $generatedFirstName = $this->generateRandomString(10);
        $generatedLastName = $this->generateRandomString(12);
        $payload = [
            "first_name" => $generatedFirstName,
            "last_name" => $generatedLastName,
        ];

        $response = $this->putJson('/user/updateMyProfile', [
            'json' => $payload,
            'headers' => $headers
        ]);

        $this->assertContains(
            $response['status'],
            [200],
            "Expected status 200 (success), got {$response['status']}"
        );

        $this->assertEquals($generatedFirstName, $response['body']['data']['first_name']);
        $this->assertEquals($generatedLastName, $response['body']['data']['last_name']);
    }
}
