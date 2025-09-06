<?php

namespace App\Tests\Controller\User;

use App\Tests\HttpTestCase;
use App\Tests\EnvConfig;

/**
 * @group user
 */
class UpdateProfileControllerTest extends HttpTestCase
{
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

        $payload = [
            "first_name" => 'ChangedName',
            "last_name" => 'ChangedSurname',
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
    }
}
