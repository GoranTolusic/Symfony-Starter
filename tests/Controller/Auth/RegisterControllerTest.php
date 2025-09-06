<?php

namespace App\Tests\Controller\Auth;

use App\Tests\HttpTestCase;
use App\Tests\EnvConfig;

class RegisterControllerTest extends HttpTestCase
{
    private EnvConfig $env;

    //HttpTestCase has final __constructor so we cant override it, but we can use setUp which is called before every test by defaul
    //We are using it to setup singleton env config so we can have quick access to some useful variables
    protected function setUp(): void
    {
        parent::setUp();
        $this->env = EnvConfig::getInstance();
    }

    public function testRegisterWithValidPayload(): void
    {
        $payload = [
            "email" => $this->env->get('TEST_EMAIL'),
            "first_name" => "Test",
            "last_name" => "Testović",
            "password" => $this->env->get('TEST_PASSWORD'),
            "tags" => ["Jedan", "Dva", "Tri", "Četiri", "Pet", "Šest", "Sedam", "Osam", "Devet", "Deset"],
        ];

        $response = $this->postJson('/auth/register', $payload);
        $this->assertContains(
            $response['status'],
            [200, 409],
            "Expected status 200 (created) or 409 (already exists), got {$response['status']}"
        );
    }

    public function testRegisterWithInvalidPayload(): void
    {
        $payload = [
            'email' => 'not-an-email',
            'password' => ''
        ];

        $response = $this->postJson('/auth/register', $payload);
        $this->assertEquals(400, $response['status']);
    }
}
