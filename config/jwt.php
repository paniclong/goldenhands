<?php

declare(strict_types=1);

return [
    'secret_key' => env('JWT_SECRET_KEY'),
    'allowed_algo' => [
        'sha256',
    ],
    'algo' => env('JWT_ALGO'),
    'ttl' => 10 * 60, // 10 min
    'refresh_token_ttl' => (60 ** 2) * 24 * 60, // 60 days
];
