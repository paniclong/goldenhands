<?php

declare(strict_types=1);

namespace App\Modules\Auth\Services;

enum ErrorCodes: int
{
    case USER_NOT_FOUND = 10001;
}
