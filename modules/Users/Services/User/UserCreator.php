<?php

declare(strict_types=1);

namespace BotAcademy\Users\Services\User;

use BotAcademy\Users\Http\Requests\Auth\DTO\SignUpUserDTO;
use BotAcademy\Users\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserCreator
{
    /**
     * @param SignUpUserDTO $dto
     * @return User
     */
    public function createFromDTO(SignUpUserDTO $dto): User
    {
        $user = new User();
        $user->name = $dto->getName();
        $user->email = $dto->getEmail();
        $user->password = Hash::make($dto->getPassword());
        if ($dto->isRemember()) {
            $user->remember_token = Str::random(10);
        }
        $user->save();

        return $user;
    }
}
