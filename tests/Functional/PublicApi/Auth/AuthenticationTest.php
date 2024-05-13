<?php

declare(strict_types=1);

namespace Tests\Functional\PublicApi\Auth;

use Tests\Functional\ApiTestCase;

class AuthenticationTest extends ApiTestCase
{
    public function testSignUp()
    {
        $name = 'Test';
        $email = 'test3' . time() . '@gmail.com';
        $password = '123456';

        $response = $this->postJson('/api/v1/users', [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password
                ]
            ]
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['type' => 'users']);
        $response->assertJsonFragment(['name' => $name]);
        $response->assertJsonFragment(['email' => $email]);
    }

    public function testSignIn()
    {
        $name = 'Test';
        $email = 'test3' . time() . '@gmail.com';
        $password = '123456';
        $response = $this->postJson('/api/v1/users', [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password
                ]
            ]
        ]);
        $response->assertStatus(201);

        $response = $this->postJson('/api/v1/users/sign-in', [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'email' => $email,
                    'password' => $password
                ]
            ]
        ]);

        $response->assertOk();
        $response->assertJsonFragment(['type' => 'users']);
        $response->assertJsonFragment(['name' => $name]);
        $response->assertJsonFragment(['email' => $email]);
    }

    public function testRefresh()
    {
        $name = 'Test';
        $email = 'test3' . time() .'@gmail.com';
        $password = '123456';
        $response = $this->postJson('/api/v1/users', [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password
                ]
            ]
        ]);
        $response->assertStatus(201);
        $token = $response['meta']['token']['refresh_token'] ?? null;

        $response = $this->postJson('/api/v1/users/refresh', [
            'meta' => [
                'token' => $token
            ]
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'meta' => [
                'token' => [
                    'token_type',
                    'expires_in',
                    'access_token',
                    'refresh_token'
                ]
            ]
        ]);
    }

    public function testGetMeAndLogout(): void
    {
        $user = $this->createTestUser();

        $response = $this->authGet($user, '/api/v1/users/me');
        $response->assertOk();

        $response = $this->authPostJson($user, '/api/v1/users/logout', []);
        $response->assertOk();
    }
}
