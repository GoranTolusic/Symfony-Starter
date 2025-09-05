<?php

namespace App\Tests\Controller\Auth;

use App\Tests\HttpTestCase;

class RegisterControllerTest extends HttpTestCase
{
    public function testRegisterWithValidPayload(): void
    {
        $payload = [
            'email' => 'testDuplicate@example.com',
            'password' => 'password123'
        ];

        $response = $this->postJson('/auth/register', $payload);

        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('success', $response['status']);
    }

    public function testRegisterWithDuplicateEmail(): void
    {
        $payload = [
            'email' => 'testDuplicate@example.com',
            'password' => 'password123'
        ];

        $this->postJson('/auth/register', $payload);

        $response = $this->postJson('/auth/register', $payload);

        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('error', $response['status']);
        $this->assertEquals(409, $response['code']);
    }

    public function testRegisterWithInvalidPayload(): void
    {
        $payload = [
            'email' => 'not-an-email',
            'password' => ''
        ];

        $response = $this->postJson('/auth/register', $payload);

        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('error', $response['status']);
        $this->assertEquals(422, $response['code']);
    }
}
