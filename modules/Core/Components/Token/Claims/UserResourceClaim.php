<?php

declare(strict_types=1);

namespace BotAcademy\Core\Components\Token\Claims;

use BotAcademy\Users\Models\User;
use CorBosman\Passport\AccessToken;
use Illuminate\Support\Facades\Request;
use LaravelJsonApi\Core\Document\Links;
use LaravelJsonApi\Core\Responses\DataResponse;

class UserResourceClaim
{
    /**
     * @param AccessToken $token
     * @param \Closure $next
     * @return mixed
     */
    public function handle(AccessToken $token, \Closure $next): mixed
    {
        /** @var User|null $user */
        $user = User::query()->find($token->getUserIdentifier());
        if (!$user) {
            return $next($token);
        }

        $data = DataResponse::make($user)
            ->withLinks(new Links())
            ->withServer('v1')
            ->toResponse(Request::instance())
            ->content();
        $data = base64_encode($data);

        $token->addClaim('ueo', $data);

        return $next($token);
    }
}
