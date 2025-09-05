<?php

namespace App\Tests\Controller\Auth;

use App\Tests\HttpTestCase;

class RegisterControllerTest extends HttpTestCase
{
    public function testRegisterWithValidPayload(): void
    {
        $payload = [
            "email" => "test-testovic123456@example.com",
            "first_name" => "Test",
            "last_name" => "Testović",
            "password" => "1234Pet",
            "tags" => ["Jedan", "Dva", "Tri", "Četiri", "Pet", "Šest", "Sedam", "Osam", "Devet", "Deset"],
        ];

        $response = $this->postJson('/auth/register', $payload);
        $this->assertEquals(200, $response['status']);

        //$this->assertArrayHasKey('status', $response);
        //$this->assertEquals('success', $response['status']);
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
