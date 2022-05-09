<?php

declare(strict_types=1);

namespace App\Modules\Auth\Services;

use App\Modules\Auth\Exception\ParseTokenSettingsException;
use App\Modules\Auth\Model\UserSession;
use App\Modules\Auth\ValueObject\JwtPayload;
use App\Modules\Auth\ValueObject\JwtToken;
use Carbon\Carbon;
use JsonException;

final class JwtTokenService
{
    private array $header = [
        'alg' => 'HS256',
        'typ' => 'JWT',
    ];

    public function __construct(
        private readonly JwtHelper $jwtHelper
    ) {
    }

    /**
     * @param string $email
     *
     * @return JwtToken
     *
     * @throws JsonException
     * @throws ParseTokenSettingsException
     */
    public function createTokenByUserSession(UserSession $userSession): JwtToken
    {
        $ttl = $this->jwtHelper->getTokenTtl();

        $expiresIn = Carbon::now()
            ->addSeconds($ttl)
            ->format(DATE_COOKIE);

        $claims = [
            'id' => $userSession->getQueueableId(),
            'user_id' => $userSession->getAttributeValue('user_id'),
            'expires_in' => $expiresIn,
        ];

        $refreshToken = $userSession->getAttributeValue('refresh_token');
        $token = $this->createToken($claims);

        return new JwtToken($token, $refreshToken, $expiresIn);
    }

    /**
     * @param array $claims
     *
     * @return string
     *
     * @throws JsonException
     * @throws ParseTokenSettingsException
     */
    protected function createToken(array $claims): string
    {
        $header = $this->jwtHelper->base64WithJsonEncode($this->header);
        $payload = $this->jwtHelper->base64WithJsonEncode($claims);
        $signature = $this->jwtHelper->base64Encode($this->jwtHelper->hashHmacByAlgo($header . '.' . $payload));

        return $header . '.' . $payload . '.' . $signature;
    }

    /**
     * @param array $data
     *
     * @return bool
     *
     * @throws ParseTokenSettingsException
     */
    public function isValidToken(array $data): bool
    {
        if (count($data) !== 3) {
            return false;
        }

        [$header, $payload, $signatureForCheck] = $data;

        $signature = $this->jwtHelper->base64Encode($this->jwtHelper->hashHmacByAlgo($header . '.' . $payload));

        return $signature === $signatureForCheck;
    }

    /**
     * @param string $token
     *
     * @return JwtPayload|null
     *
     * @throws JsonException
     * @throws ParseTokenSettingsException
     */
    public function getPayloadFromToken(string $token): ?JwtPayload
    {
        $data = explode('.', $token);

        if (!$this->isValidToken($data)) {
            return null;
        }

        [,$payload,] = explode('.', $token);

        return new JwtPayload(...$this->jwtHelper->base64WithJsonDecode($payload));
    }
}
