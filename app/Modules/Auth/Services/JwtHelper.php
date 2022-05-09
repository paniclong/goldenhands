<?php

declare(strict_types=1);

namespace App\Modules\Auth\Services;

use App\Modules\Auth\Exception\ParseTokenSettingsException;
use JsonException;

final class JwtHelper
{
    /**
     * @param string $data
     *
     * @return string
     */
    public function base64Encode(string $data): string
    {
        return base64_encode($data);
    }

    /**
     * @param array $data
     *
     * @return string
     *
     * @throws JsonException
     */
    public function base64WithJsonEncode(array $data): string
    {
        return base64_encode(json_encode($data, JSON_THROW_ON_ERROR));
    }

    /**
     * @param string $data
     *
     * @return array
     *
     * @throws JsonException
     */
    public function base64WithJsonDecode(string $data): array
    {
        return json_decode(json: base64_decode($data), associative: true, flags: JSON_THROW_ON_ERROR);
    }

    /**
     * @param string $data
     *
     * @return string
     *
     * @throws ParseTokenSettingsException
     */
    public function hashHmacByAlgo(string $data): string
    {
        [$algo, $secretKey] = $this->getJwtConfig();

        return (string)hash_hmac($algo, $data, $secretKey);
    }

    /**
     * @return array
     *
     * @throws ParseTokenSettingsException
     */
    public function getJwtConfig(): array
    {
        $secretKey = config('jwt.secret_key');
        $allowedAlgo = config('jwt.allowed_algo');
        $algo = config('jwt.algo');

        if (!in_array($algo, $allowedAlgo, true) || !$secretKey) {
            throw new ParseTokenSettingsException();
        }

        return [$algo, $secretKey];
    }

    /**
     * @return int
     */
    public function getTokenTtl(): int
    {
        return config('jwt.ttl', 0);
    }

    /**
     * @return int
     */
    public function getRefreshTokenTtl(): int
    {
        return config('refresh_token_ttl', 0);
    }
}
