<?php

declare(strict_types=1);

namespace BotAcademy\Users\Services\Auth;

use BotAcademy\Users\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class Authenticator implements AuthenticatorInterface
{
    /**
     * @param string $login
     * @param string $password
     * @return User
     * @throws AuthenticationException
     */
    public function authenticate(string $login, string $password): User
    {
        /** @var User|null $user */
        $user = User::query()->where('email', $login)->first();
        if (!$user) {
            throw new AuthenticationException();
        }

        if (!Hash::check($password, $user->password)) {
            throw new AuthenticationException();
        }

        return $user;
    }

    /**
     * @return User
     * @throws AuthenticationException
     */
    public function getCurrentUser(): User
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user) {
            throw new AuthenticationException();
        }

        return $user;
    }

    /**
     * @return void
     * @throws AuthenticationException
     */
    public function logout(): void
    {
        $user = $this->getCurrentUser();
        /** @var PersonalAccessToken|null $token */
        $token = $user->currentAccessToken();
        if (!$token) {
            return;
        }

        $user->tokens()->where('token', $token->token)->delete();
    }
}
