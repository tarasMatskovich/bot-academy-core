<?php

declare(strict_types=1);

namespace BotAcademy\Users\Http\Requests\Auth;

use BotAcademy\Users\Http\Requests\Request;

class RefreshRequest extends Request
{
    public function rules(): array
    {
        return [
            'meta.token' => ['required', 'string'],
        ];
    }

    public function getToken(): string
    {
        return $this->input('meta.token');
    }
}
