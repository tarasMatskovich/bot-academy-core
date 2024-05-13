<?php

declare(strict_types=1);

namespace BotAcademy\Users\Http\Requests\Auth;

use BotAcademy\Users\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SignInRequest extends Request
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'data.type'                => ['required', Rule::in('users')],
            'data.attributes.email'    => ['required', 'email', 'max:255'],
            'data.attributes.password' => ['required', 'min:6', 'max:255'],
            'meta.is_remember'         => ['bool'],
        ];
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return (string)$this->input('data.attributes.email');
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return (string)$this->input('data.attributes.password');
    }

    /**
     * @return bool
     */
    public function isRemember(): bool
    {
        return $this->boolean('meta.is_remember');
    }
}
