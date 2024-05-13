<?php

declare(strict_types=1);

namespace BotAcademy\Users\Http\Controllers\PublicApi\Auth;

use BotAcademy\Users\Http\Controllers\Controller;
use BotAcademy\Users\Http\Requests\Auth\SignInRequest;
use BotAcademy\Users\Http\Requests\Auth\SignUpRequest;
use BotAcademy\Users\Services\Auth\Authenticator;
use BotAcademy\Users\Services\User\UserCreator;
use Illuminate\Http\JsonResponse;
use LaravelJsonApi\Core\Responses\DataResponse;

class AuthController extends Controller
{
    /**
     * @param SignUpRequest $request
     * @param UserCreator $creator
     * @return DataResponse
     * @throws \Exception
     */
    public function store(
        SignUpRequest $request,
        UserCreator $creator
    ): DataResponse {
        $dto = $request->toDTO();
        $user = $creator->createFromDTO($dto);
        $token = $user->createToken('api');

        return DataResponse::make($user)
            ->withServer('v1')
            ->withMeta([
                'token' => $token->plainTextToken,
                'is_remember' => $dto->isRemember()
            ]);
    }

    /**
     * @param SignInRequest $request
     * @param Authenticator $authenticator
     * @return DataResponse
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function signIn(
        SignInRequest $request,
        Authenticator $authenticator
    ): DataResponse {
        $user = $authenticator->authenticate($request->getEmail(), $request->getPassword());
        $token = $user->createToken('api');

        return DataResponse::make($user)
            ->withServer('v1')
            ->withMeta([
                'token' => $token->plainTextToken,
                'is_remember' => $request->isRemember()
            ]);
    }

    /**
     * @param Authenticator $authenticator
     * @return DataResponse
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function me(Authenticator $authenticator): DataResponse
    {
        return DataResponse::make($authenticator->getCurrentUser())->withServer('v1');
    }

    /**
     * @param Authenticator $authenticator
     * @return JsonResponse
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function logout(Authenticator $authenticator): JsonResponse
    {
        $authenticator->logout();

        return new JsonResponse(null, 200);
    }
}
