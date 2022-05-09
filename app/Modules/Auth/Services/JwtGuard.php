<?php

declare(strict_types=1);

namespace App\Modules\Auth\Services;

use App\Models\User;
use App\Modules\Auth\ValueObject\JwtToken;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use JsonException;

class JwtGuard implements Guard
{
    use GuardHelpers;

    public function __construct(
        readonly private UserProvider $userProvider,
        readonly private Request $request,
        readonly private JwtTokenService $jwtTokenService,
        readonly private UserSessionService $userSessionService
    ) {

    }

    /**
     * @return bool
     *
     * @throws JsonException
     */
    public function isValidToken(): bool
    {
        $token = $this->request->get('token', '');

        $jwtPayload = $this->jwtTokenService->getPayloadFromToken($token);

        return $jwtPayload === null || !$jwtPayload->isExpired();
    }

    /**
     * @return Authenticatable|null
     *
     * @throws JsonException
     */
    public function user()
    {
        $token = $this->request->get('token', '');

        $jwtPayload = $this->jwtTokenService->getPayloadFromToken($token);

        if ($jwtPayload === null || $jwtPayload->isExpired()) {
            return null;
        }

        return $this->userProvider->retrieveById($jwtPayload->getUserId());
    }

    /**
     * @param array $credentials
     *
     * @return JwtToken|false
     *
     * @throws JsonException
     * @throws \App\Modules\Auth\Exception\ParseTokenSettingsException
     */
    public function attempt(array $credentials): JwtToken|false
    {
        /** @var User $user */
        $user = $this->userProvider->retrieveByCredentials($credentials);

        if ($user === null) {
            return false;
        }

        if (!$user->isAvailableCreateNewSession()) {
            $user->sessions()->first()?->delete();
        }

        $userSession = $this->userSessionService->create($user->getAuthIdentifier(), $this->request);

        return $this->jwtTokenService->createTokenByUserSession($userSession);
    }

    /**
     * @param array $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = []): bool
    {
        return $this->provider->retrieveByCredentials($credentials) instanceof Authenticatable;
    }

    /**
     * @param string $refreshToken
     *
     * @return JwtToken|bool
     *
     * @throws \App\Modules\Auth\Exception\ParseTokenSettingsException
     * @throws JsonException
     */
    public function refreshToken(string $refreshToken): JwtToken|bool
    {
        $userSession = $this->userSessionService->findOneByRefreshToken($refreshToken);

        if ($userSession === null) {
            return false;
        }

        $userId = $userSession->getUserId();
        $userSession->delete();

        $userSession = $this->userSessionService->create($userId, $this->request);

        return $this->jwtTokenService->createTokenByUserSession($userSession);
    }
}
