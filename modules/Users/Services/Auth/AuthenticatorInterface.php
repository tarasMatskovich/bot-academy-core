<?php

declare(strict_types=1);

namespace BotAcademy\Users\Services\Auth;

use BotAcademy\Users\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

interface AuthenticatorInterface
{
    public function authenticate(string $login, string $password): User;

    public function getCurrentUser(): User;

    public function logout(): void;
}
