<?php

namespace Tests;

use BotAcademy\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    public function createTestUser(
        string $name = null,
        string $email = null
    ): User {
        $user = new User();
        $user->name = $name ?? 'Test';
        $user->email = $email ?? "test-case" . time() . "@gmail.com";
        $hash = Hash::make('123456');
        $user->password = $hash;
        $user->save();

        return $user;
    }
}
