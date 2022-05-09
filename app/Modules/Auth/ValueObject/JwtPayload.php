<?php

declare(strict_types=1);

namespace App\Modules\Auth\ValueObject;

use Carbon\Carbon;

final class JwtPayload
{
    readonly private int $id;
    readonly private int $userId;
    readonly private string $expiresIn;

    public function __construct(int $id, int $userId, string $expiresIn)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getExpiresIn(): string
    {
        return $this->expiresIn;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        $now = Carbon::now();

        return Carbon::createFromTimestamp(strtotime($this->getExpiresIn()))
            ->addMinute()
            ->lessThan($now);
    }
}
