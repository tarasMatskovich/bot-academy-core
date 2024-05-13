<?php

declare(strict_types=1);

namespace Tests\Functional;

use BotAcademy\Users\Models\User;
use BotAcademy\Users\Services\OAuth\Token\Token;
use BotAcademy\Users\Services\OAuth\Token\TokenCreator;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ApiTestCase extends TestCase
{
    protected TokenCreator $tokenCreator;

    protected array $tokens = [];

    public function setUp(): void
    {
        parent::setUp();
        $this->tokenCreator = resolve(TokenCreator::class);
        $this->tokens = [];
    }

    protected function createToken(User $user): Token
    {
        $token = $this->tokens[$user->email] ?? null;
        if (!$token) {
            $token = $this->tokens[$user->email] = $this->tokenCreator->createToken($user->email, '123456');
        }
        return $token;
    }

    public function authGet(User $user, string $uri): TestResponse
    {
        $token = $this->createToken($user);

        return $this->be($user, 'api')->get($uri, [
            'Authorization' => 'Bearer ' . $token->getAccessToken(),
        ]);
    }

    public function authPostJson(User $user, string $uri, array $data): TestResponse
    {
        $token = $this->createToken($user);

        return $this->be($user, 'api')->postJson($uri, $data, [
            'Authorization' => 'Bearer ' . $token->getAccessToken()
        ]);
    }
}
