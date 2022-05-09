<?php

declare(strict_types=1);

namespace App\Modules\Auth\ValueObject;

final class JwtToken
{
    readonly private string $token;
    readonly private string $refreshToken;
    readonly private string $expiresIn;

    /**
     * @param string $token
     * @param string $refreshToken
     * @param string $expiresIn
     */
    public function __construct(string $token, string $refreshToken, string $expiresIn)
    {
        $this->token = $token;
        $this->refreshToken = $refreshToken;
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @return string
     */
    public function getExpiresIn(): string
    {
        return $this->expiresIn;
    }
}
