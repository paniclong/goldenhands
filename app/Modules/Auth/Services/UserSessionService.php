<?php

declare(strict_types=1);

namespace App\Modules\Auth\Services;

use App\Modules\Auth\Model\UserSession;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserSessionService
{
    public function __construct(
        private readonly JwtHelper $jwtHelper,
    ) {

    }
    
    /**
     * @param int $userId
     * @param Request $request
     *
     * @return UserSession
     */
    public function create(int $userId, Request $request): UserSession
    {
        $ttl = $this->jwtHelper->getRefreshTokenTtl();
        
        $expiresIn = Carbon::now()
            ->addSeconds($ttl)
            ->getTimestamp();

        $userSession = new UserSession();
        $userSession->setAttribute('refresh_token', Str::uuid()->toString());
        $userSession->setAttribute('expires_in', $expiresIn);
        $userSession->setAttribute('user_id', $userId);
        $userSession->setAttribute('ip', $request->ip());
        $userSession->setAttribute('user_agent', $request->userAgent());
        $userSession->setAttribute('device', 'desktop');
        $userSession->save();

        return $userSession;
    }

    /**
     * @param string $refreshToken
     * 
     * @return Model|UserSession|null
     */
    public function findOneByRefreshToken(string $refreshToken): ?UserSession
    {
        return UserSession::query()
            ->where('refresh_token', '=', $refreshToken)
            ->first();
    }
}
