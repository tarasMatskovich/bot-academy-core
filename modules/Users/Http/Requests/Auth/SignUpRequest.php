<?php

declare(strict_types=1);

namespace BotAcademy\Users\Http\Requests\Auth;

use BotAcademy\Users\Http\Requests\Auth\DTO\SignUpUserDTO;
use BotAcademy\users\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SignUpRequest extends Request
{
    public function rules(): array
    {
        return [
            'data.type'                => ['required', Rule::in('users')],
            'data.attributes.email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'data.attributes.name'     => ['required', 'max:255'],
            'data.attributes.password' => ['required', 'min:6', 'max:255'],
            'meta.is_remember'         => ['bool'],
        ];
    }

    /**
     * @return SignUpUserDTO
     */
    public function toDTO(): SignUpUserDTO
    {
        $name = (string)$this->input('data.attributes.name');
        $email = (string)$this->input('data.attributes.email');
        $password = (string)$this->input('data.attributes.password');
        $isRemember = (bool)$this->input('meta.is_remember');

        return new SignUpUserDTO(
            $name,
            $email,
            $password,
            $isRemember
        );
    }
}
